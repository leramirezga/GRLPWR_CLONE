<?php

namespace App\Http\Controllers;

use App\EditedEvent;
use App\Exceptions\NoAvailableEquipmentException;
use App\Exceptions\NoVacancyException;
use App\Exceptions\ShoeSizeNotSupportedException;
use App\Exceptions\WeightNotSupportedException;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Services\KangooService;
use App\Model\Cliente;
use App\Model\Evento;
use App\Model\Peso;
use App\Model\Review;
use App\Model\ReviewSession;
use App\Model\SesionCliente;
use App\RemainingClass;
use App\Repositories\ClientPlanRepository;
use App\User;
use App\Utils\PlanTypesEnum;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SesionClienteController extends Controller
{
    public function __construct(KangooService $kangooService)
    {
        $this->kangooService = $kangooService;
    }

    public function save(int $eventId, int $clienteId, $sesionClienteId, $startDate, $endDate)
    {
        if($sesionClienteId != "null"){//La sesion fue creada con reserva de kangoo, así que se confirma
            $sesionCliente = SesionCliente::find($sesionClienteId);
            $sesionCliente->reservado_hasta = null;
        }else{
            $sesionCliente = new SesionCliente();
            $sesionCliente->cliente_id = $clienteId;
            $sesionCliente->evento_id = $eventId;
            $sesionCliente->fecha_inicio = $startDate;
            $sesionCliente->fecha_fin = $endDate;
        }
        $sesionCliente->save();
    }

    public function scheduleEvent(Request $request){
        try {
            $client = Cliente::find($request->clientId);
            return $this->schedule($request->eventId, $request->startDate, $request->startHour, $request->endDate, $request->endHour, $client, $request->rentEquipment, $request->isCourtesy ?? false, $request->validateVacancy ?? false);
        }catch (Exception $exception){
            Session::put('msg_level', 'danger');
            Session::put('msg', $exception->getMessage());
            Session::save();
            return response()->json(['error' =>  $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function scheduleCourtesy(Request $request){

        $user = User::where('email', $request->email)
                    ->orWhere('telefono', $request->cellphone)
                    ->first();

        if($user){
            if(SesionCliente::where('cliente_id', $user->id)->first()){
                Session::put('msg_level', 'danger');
                Session::put('msg', __('general.already_registered_for_courtesy'));
                Session::save();
                return redirect()->back();
            }
        }else{
            $registerController = new RegisterController();
            $request->merge(['password' => config('app.default_password')]);
            $user = $registerController->create($request->all());
        }

        $client = Cliente::updateOrCreate(
            ['usuario_id' => $user->id],
            [
                'talla_zapato' => $request->shoeSize ?? null,
                'objective' => request()->objective,
                'pathology' => $request->pathology,
                'channel' => request()->channel
                //'peso_ideal' => request()->pesoIdeal,
                //'biotipo' => request()->tipoCuerpo
            ]
        );
        $client->usuario_id = $user->id;

        if($request->weight){
            Peso::updateOrCreate(
                ['usuario_id' => $user->id],
                ['peso' => $request->weight, 'unidad_medida' => 0]
            );
        }

        try {
            $eventArray = json_decode($request->event, true);
            return $this->schedule($eventArray['id'], $eventArray['startDate'], $eventArray['startHour'], $eventArray['endDate'], $eventArray['endHour'], $client, $request->get('rentEquipment'), true, true);
        }catch (Exception $exception){
            return redirect()->back()->with('errors', $exception->getMessage());
        }
    }

    /**
     * @throws ShoeSizeNotSupportedException
     * @throws NoVacancyException
     * @throws NoAvailableEquipmentException
     * @throws WeightNotSupportedException
     *
     */
    private function schedule($id, $startDate, $startHour, $endDate, $endHour, $client, $isRenting, $isCourtesy, $validateVacancy): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $editedEvent = EditedEvent::where('evento_id', $id)
            ->where('fecha_inicio', '=', $startDate)
            ->where('start_hour', '=', $startHour)
            ->first();
        $event = $editedEvent ?: Evento::find($id);
        $startDateTime = Carbon::parse($startDate)->format('Y-m-d') . ' ' . $startHour;
        $endDateTime = Carbon::parse($endDate)->format('Y-m-d') . ' ' . $endHour;
        $scheduled_clients = SesionCliente::where('evento_id', $event->id)
            ->where('fecha_inicio', '=', $startDateTime)
            ->where('fecha_fin', '=', $endDateTime)->count();
        if(filter_var($validateVacancy, FILTER_VALIDATE_BOOLEAN) && $event->cupos <= $scheduled_clients){
           throw new NoVacancyException();
        }

        if(filter_var($isRenting, FILTER_VALIDATE_BOOLEAN)){
            $kangooId = $this->assignEquipment($event, $client->talla_zapato, $client->peso()->peso, $startDateTime, $endDateTime);
        }
        $isCourtesy = filter_var($isCourtesy, FILTER_VALIDATE_BOOLEAN);
        return $this->registerSession($client->usuario_id, $event, $startDateTime, $endDateTime, $isCourtesy, $kangooId ?? null);

    }

    /**
     * @throws ShoeSizeNotSupportedException
     * @throws NoAvailableEquipmentException
     * @throws WeightNotSupportedException
     */
    public function assignEquipment(Evento $event, $shoeSize, $weight, $startDateTime, $endDateTime){
        if(strcasecmp($event->classType->type, PlanTypesEnum::KANGOO->value) == 0 || strcasecmp($event->classType->type, PlanTypesEnum::KANGOO_KIDS->value) == 0){
            return $this->kangooService->assignKangoo($shoeSize, $weight, $startDateTime, $endDateTime);
        }
    }


    /**
     *Renta
        si:
            plan:
                si: crea sesion con kangoo y descuenta remaining   	(CASE A)
                no: crea sesion con reserva y lo envia a pagar 		(CASE B)

        no:
            plan:
                si: crea sesion y descuenta remaining              	(CASE C)
                no: lo envía a pagar								(CASE D)
     * @param $clientId
     * @param $event
     * @param $startDateTime
     * @param $endDateTime
     * @param null $kangooId
     * @return JsonResponse | \Illuminate\Http\RedirectResponse
     */
    public function registerSession($clientId, $event, $startDateTime, $endDateTime, $isCourtesy, $kangooId=null)
    {
        DB::beginTransaction();

        try{
            $sesionCliente = new SesionCliente;
            $sesionCliente->cliente_id = $clientId;
            $sesionCliente->evento_id = $event->id;
            if($kangooId){
                $sesionCliente->kangoo_id = $kangooId;
            }
            $sesionCliente->fecha_inicio = $startDateTime;
            $sesionCliente->fecha_fin = $endDateTime;
            $sesionCliente->is_courtesy = $isCourtesy;

            if($isCourtesy){
                $sesionCliente->save();
                Session::put('msg_level', 'success');
                Session::put('msg', __('general.success_courtesy'));
                Session::save();
                DB::commit();
                return redirect()->back();
            }

            $clientPlanRepository = new ClientPlanRepository();
            $event->fecha_inicio = $startDateTime;
            $event->fecha_fin = $endDateTime;
            $clientPlan = $clientPlanRepository->findValidClientPlan($event, $clientId);

            if ($clientPlan) {
                $sesionCliente->save();
                if($clientPlan->remaining_shared_classes != null){
                    $clientPlan->remaining_shared_classes--;
                    $clientPlan->save();
                }
                /*FIT-57: Uncomment this if you want specific classes*/
                else{
                    $remainingClass = RemainingClass::find($clientPlan->remaining_classes_id);
                    if($remainingClass) {
                        if($remainingClass->unlimited == 0){
                            $remainingClass->remaining_classes--;
                            $remainingClass->save();
                        }
                    }
                }
                /*FIT-57: end block code*/

                Session::put('msg_level', 'success');
                Session::put('msg', __('general.success_purchase'));
                Session::save();
                DB::commit();
                return response()->json(['status' =>  'success'], 201);
            }else if($kangooId){
                $sesionCliente->reservado_hasta = Carbon::now()->addMinutes(5);
                $sesionCliente->save();
                Session::put('msg_level', 'success');
                Session::put('msg', __('general.reserved_5_minutes'));
                Session::save();
                DB::commit();
                return response()->json(['status' =>  'reserved', 'sesionClienteId' => $sesionCliente->id], 200);
            }
            DB::commit();
            return response()->json(['status' =>  'goToPay'], 200);
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error("ERROR SesionClienteController - registerSession - courtesy: " . $exception->getMessage());
            Session::put('msg_level', 'danger');
            Session::put('msg', __('general.error_general'));
            Session::save();
            if($isCourtesy){
                return redirect()->back();
            }
            return response()->json(status:  500);
        }
    }

    public function cancelTraining(){
        return DB::transaction(function () {
            try {
                $session = SesionCliente::find(request()->entrenamientoCancelar);
                if($session->fecha_inicio <= now() ) {
                    Session::put('msg_level', 'danger');
                    Session::put('msg', __('general.message_late_cancellation'));
                    Session::save();
                    return back();
                }
                if($session->fecha_inicio->subHours(HOURS_TO_CANCEL_TRAINING) < now()){
                    $session->delete();
                    Session::put('msg_level', 'warning');
                    Session::put('msg', __('general.message_enable_late_cancellation'));
                    Session::save();
                    return back();
                }
                $session->delete();
                Session::put('msg_level', 'success');
                Session::put('msg', __('general.successfully_cancelled'));
                Session::save();
                $session->event->fecha_inicio = $session->fecha_inicio;
                $session->event->fecha_fin = $session->fecha_fin;
                $this->returnClassAfterCancellation($session->event);
                return back();
            } catch (Exception $exception) {
                Log::error("ERROR SesionClienteController - cancelTraining: " . $exception->getMessage());
                Session::put('msg_level', 'danger');
                Session::put('msg', __('general.error_general'));
                return back();
            }
        });
    }

    public function darReview(){
        if(request()->rating != null){
            $review = Review::create([
                'rating' => request()->rating,
                'review' => request()->review,
                'reviewer_id' => Auth::id(),
            ]);
            ReviewSession::create([
               'review_id' => $review->id,
               'session_id' => request()->reviewFor
            ]);
        }
        return back();
    }

    public function returnClassAfterCancellation(Evento $event){
        $clientPlanRepository = new ClientPlanRepository();
        $clientPlan = $clientPlanRepository->findValidClientPlan(event: $event, withRemainingClasses: false);
        if ($clientPlan) {
            if($clientPlan->remaining_shared_classes != null){
                $clientPlan->remaining_shared_classes++;
                $clientPlan->save();
            }
            /*FIT-57: Uncomment this if you want specific classes*/
            else{
                $remainingClass = RemainingClass::find($clientPlan->remaining_classes_id);
                if($remainingClass && $remainingClass->unlimited == 0) {
                    $remainingClass->remaining_classes++;
                    $remainingClass->save();
                }
            }
            /*FIT-57: end block code*/
        }
    }

    public function checkAttendee(Request $request): JsonResponse
    {
        $clientSession = SesionCliente::find($request->clientSessionId);
        $clientSession->attended = $request->checked === "true";
        $clientSession->save();

        return response()->json([
            'success' => true
        ], 200);
    }

}
