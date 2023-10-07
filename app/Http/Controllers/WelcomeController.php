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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if (auth()->check()) {
            return redirect('user/'.Auth::user()->slug.'/home');
        } else {
            return view('welcome');
        }
    }
}
