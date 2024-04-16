<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Utils\AuthEnum;
use Illuminate\Support\Facades\Auth;

class SeguridadController extends Controller
{
    public static function verificarPermisos($logeado, $rol){
        self::verificarRol($rol);
        self::verificarUsuario($logeado);
    }

    public static function verificarRol($rol){
        $user = Auth::user();
        if($user->rol!=$rol){
            abort(403, 'usuario sin el rol correcto');
        }
    }

    public static function verificarUsuario($logeado, $return = false){
        $user = Auth::user();
        if ($return) {
            return ($user != $logeado) ? AuthEnum::VISITOR : AuthEnum::SAME_USER;
        } elseif ($user != $logeado) {
            abort(403, 'usuario incorrecto');
        }
    }

}
