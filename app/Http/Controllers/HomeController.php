<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Cliente;
use App\Model\ClientPlan;
use App\Model\Entrenador;
use App\Model\Estatura;
use App\Model\Ofrecimientos;
use App\Model\Peso;
use App\Model\Review;
use App\Model\ReviewUser;
use App\Model\SesionCliente;
use App\Repositories\ClientPlanRepository;
use App\User;
use App\Utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\SolicitudServicio;
use Illuminate\Support\Facades\DB;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        SeguridadController::verificarUsuario($user);
        $visitante = false;
        if(strcasecmp ( $user->rol, Constantes::ROL_ADMIN ) == 0){
            return view('admin.homeAdmin', compact('user'));
        }
        if(strcasecmp ( $user->rol, Constantes::ROL_CLIENTE ) == 0) {
            $entrenamientosAgendados = SesionCliente::
            where('cliente_id', $user->id)
                ->entrenamientosAgendados($user->rol)
                ->get();

            $clientPlanRepository = new ClientPlanRepository();
            $clientPlans = $clientPlanRepository->findValidClientPlans();

            $Aleatorynumber = rand(1, 100);
            if ($Aleatorynumber <= config('app.probability_to_show_review_modal', 60)) {
                $lastSessionWithoutReview = DB::table('sesiones_cliente')
                    ->leftJoin('reviews_session', 'reviews_session.session_id', '=', 'sesiones_cliente.id')
                    ->whereNull('reviews_session.session_id')
                    ->where('sesiones_cliente.fecha_fin', '<', today())
                    ->orderBy('sesiones_cliente.fecha_fin', 'desc')
                    ->select('sesiones_cliente.id')
                    ->first();

                $reviewFor = $lastSessionWithoutReview?->id;
                return view('cliente.homeCliente', compact('user', 'entrenamientosAgendados', 'visitante', 'reviewFor', 'clientPlans'));
            }
            return view('cliente.homeCliente', compact('user', 'entrenamientosAgendados', 'visitante', 'clientPlans'));
        }
        if(strcasecmp ($user->rol, Constantes::ROL_ENTRENADOR) == 0){
            $ofrecimientos = Ofrecimientos::where('usuario_id', $user->id)->get();
            $solicitudes_id = array();
            foreach ($ofrecimientos as $ofrecimiento){
                array_push($solicitudes_id, $ofrecimiento->solicitud_servicio_id);
            }
            $solicitudes= SolicitudServicio::
                            whereIn('id', $solicitudes_id )
                            ->whereIn('estado', [0, 5])//solicitud activa o modificada
                            ->get();

            $entrenamientosAgendados = SolicitudServicio::
                                        whereIn('solicitudes_servicio.id', $solicitudes_id )
                                        ->entrenamientosAgendados($user->rol)
                                        ->get();

            return view('perfilEntrenador', compact('user', 'solicitudes', 'entrenamientosAgendados', 'visitante'));
        }

        //cuando se registra con redes sociales
        if(strcasecmp ($user->rol, 'indefinido' ) == 0){
            return view('register.completearRegistroRedesSociales');
        }
    }

    public function visitar(User $user){
        if($user==Auth::user()){//si el mismo va a visitar su perfil se redirecciona para que vea su perfil normal
            return redirect()->route('home', ['user' => $user]);
        }
        $solicitudes = null;
        $visitante = true;
        if(strcasecmp ($user->rol, Constantes::ROL_ENTRENADOR ) == 0) {
            return view('perfilEntrenador', compact('user', 'solicitudes', 'visitante'));
        }
        if(strcasecmp ($user->rol, Constantes::ROL_CLIENTE ) == 0) {
            return view('cliente.profileClient', compact('user', 'solicitudes', 'visitante'));
        }
    }

    public function completarRegistroRedesSociales(){
        $user = Auth::user();
        $user->rol = strtolower(request()->role);
        $user->save();
        return back();
    }
}
