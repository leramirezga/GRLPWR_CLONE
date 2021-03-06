<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\RedirectsUsers;

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

    public static function verificarUsuario($logeado){
        $user = Auth::user();
        if($user != $logeado){
            abort(403, 'usuario incorrecto');
        }
    }

}
