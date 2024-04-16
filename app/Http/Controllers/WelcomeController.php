<?php

namespace App\Http\Controllers;

use App\User;
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
