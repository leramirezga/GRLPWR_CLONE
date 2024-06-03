<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Ofrecimientos;
use App\Model\SesionCliente;
use App\Model\SolicitudServicio;
use App\User;
use App\Utils\Constantes;
use App\Utils\RolsEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        if($user->hasRole(RolsEnum::ADMIN) || $user->hasRole(RolsEnum::TRAINER)){
            return view('admin.homeAdmin', compact('user'));
        }
        if($user->hasRole(RolsEnum::CLIENT)) {
            $entrenamientosAgendados = SesionCliente::
            where('cliente_id', $user->id)
                ->entrenamientosAgendados()
                ->get();

            $randomNumber = rand(1, 100);
            if ($randomNumber <= config('app.probability_to_show_review_modal', 60)) {
                $lastSessionWithoutReview = DB::table('sesiones_cliente')
                    ->join('eventos', 'sesiones_cliente.evento_id', 'eventos.id')
                    ->leftJoin('reviews_session', 'reviews_session.session_id', '=', 'sesiones_cliente.id')
                    ->whereNull('reviews_session.session_id')
                    ->where('sesiones_cliente.cliente_id', Auth::id())
                    ->where('sesiones_cliente.fecha_inicio', '>', Carbon::now()->subDay()->startOfDay())
                    ->where('sesiones_cliente.fecha_fin', '<', today())
                    ->orderBy('sesiones_cliente.fecha_fin', 'desc')
                    ->select('sesiones_cliente.id', 'eventos.nombre')
                    ->first();

                $reviewFor = $lastSessionWithoutReview?->id;
                $eventName = $lastSessionWithoutReview?->nombre;
                return view('cliente.homeCliente', compact('user', 'entrenamientosAgendados', 'visitante', 'reviewFor', 'eventName'));
            }
            return view('cliente.homeCliente', compact('user', 'entrenamientosAgendados', 'visitante'));
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
        return view('cliente.profileClient', compact('user', 'solicitudes', 'visitante'));
    }

    public function completarRegistroRedesSociales(){
        $user = Auth::user();
        $user->rol = strtolower(request()->role);
        $user->save();
        return back();
    }
}
