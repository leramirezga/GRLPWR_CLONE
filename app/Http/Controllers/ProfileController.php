<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Cliente;
use App\Model\Entrenador;
use App\Model\Estatura;
use App\Model\Peso;
use App\Model\ReviewUser;
use App\User;
use App\Utils\AuthEnum;
use App\Utils\Constantes;
use App\Utils\RolsEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class ProfileController extends Controller
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
        $userType = SeguridadController::verificarUsuario($user, true);
        if($user->hasRole(RolsEnum::CLIENT)){
            return $userType == AuthEnum::SAME_USER ?
                view('cliente.profileClient', compact('user')) :
                redirect()->route('visitarPerfil', ['user' => $user]);
        }
        if($user->hasRole(RolsEnum::TRAINER)){
            redirect()->route('visitarPerfil', ['user' => $user]);
        }
        //cuando se registra con redes sociales
        if(strcasecmp ($user->rol, 'indefinido' ) == 0){
            return view('register.completearRegistroRedesSociales');
        }
    }

    public function actualizarPerfil(Request $request){
        //Solo se validan lo de los primeros tabs, porque el último tab se valida con JS

        /*Para que sepan de cual modal viene el error y poder mostrarlo*/
            $validator = Validator::make($request->all(), [
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                'firstname' => 'string|required',
                'lastname' => 'string|required',
                'dateborn' => 'required',
                'documentId' => 'numeric|required',
                'eps' => 'string|required',
                'maritalStatus' => 'string|required',
                'occupation' => 'string|required',
                'channel' => 'string|required',
                'emergencyContact' => 'string|required',
                'emergencyPhone' => 'numeric|required',
                //'genero' => 'string|required',
                //'ciudad' => 'string|required',
                'cellphone' => 'numeric|required',
                'email' => 'email|required|string',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator, 'completarPerfil')
                    ->withInput();
            }
        /*****************************************************************/

        $user = Auth::user();
        $user -> fecha_nacimiento =date('Y-m-d', strtotime(str_replace('/', '-', request()->dateborn)));
        $user -> nombre = request()->firstname;
        $user -> apellido_1 = request()->lastname;
        $user -> apellido_2 = request()->lastname2;
        $user -> telefono = request()->cellphone;
        $user -> document_id = request()->documentId;
        $user -> eps = request()->eps;
        $user -> marital_status = request()->maritalStatus;
        $user -> instagram = request()->instagram;
        $user -> emergency_contact = request()->emergencyContact;
        $user -> emergency_phone = request()->emergencyPhone;
        $user -> occupation = request()->occupation;
        $user -> descripcion = request()->descripcion;
        $user -> genero = request()->genero ?? 'f';//By default female because is a feminine gym
        $user -> ciudad = 'bogota';//request()->ciudad;

        $image = $request->file('avatar');
        if($image != null){
            $user -> foto = $user->id;
            //$image->storeAs('avatars', $user->id);//TODO DESCOMENTAR ESTO CUANDO FUNCIONE EL ALMACENAMIENTO EN HEROKU
            $image->storeAs('images/avatars', $user->id, 'uploads');//TODO LUEGO DE ARREGLAR EL ALAMCENAMIENTO EN HEROKU QUITAR EL UPLOADS DE filesystem.php
        }

        $user->save();

        $reviewId = 0;
        if($user->hasRole(RolsEnum::CLIENT)) {
            $reviewId = 1;
            Cliente::updateOrCreate(
                ['usuario_id' => $user->id],
                [
                    'talla_zapato' => request()->tallaZapato,
                    'objective' => request()->objective,
                    'pathology' => request()->pathology,
                    'channel' => request()->channel
                    //'peso_ideal' => request()->pesoIdeal,
                    //'biotipo' => request()->tipoCuerpo
                ]
            );

            $lastWeight = Peso::where('usuario_id', $user->id)->orderBy('created_at', 'desc')->first();
            if(!$lastWeight){
                $lastWeight = new Peso();
                $lastWeight->usuario_id = $user->id;
                $lastWeight->unidad_medida = 0;
            }
            $lastWeight->peso = request()->peso;
            $lastWeight->save();

            Estatura::updateOrCreate(
                ['usuario_id' => $user->id],
                ['estatura' => request()->estatura, 'unidad_medida' => 1]
            );

            Session::put('msg_level', 'success');
            Session::put('msg', Constantes::MENSAJE_ACTUALIZACION_PERFIL_EXITOSA);
            Session::save();

        }elseif (strcasecmp ($user->rol, Constantes::ROL_ENTRENADOR ) == 0){
            $reviewId = 2;
            Entrenador::updateOrCreate(
                ['usuario_id' => $user->id],
                ['tipo_cuenta' => request()->tipoCuenta, 'banco' => request()->banco, 'numero_cuenta' => request()->numeroCuenta, 'tarifa' => request()->tarifa]
            );

            request()->session()->flash('alert-success', 'Tu perfil ahora está actualizado, A ENTRENAR!');
        }

        $reviewUser = ReviewUser::where('review_id', 1)
            ->where('user_id', $user->id)
            ->first();
        if ($reviewUser === null && $reviewId != 0) {

            ReviewUser::create(
                ['review_id' => $reviewId,
                    'user_id' => $user->id,
                ]
            );
        }

        return back();
    }

    public function completarRegistroRedesSociales(){
        $user = Auth::user();
        $user->rol = strtolower(request()->role);
        $user->save();
        return back();
    }
}
