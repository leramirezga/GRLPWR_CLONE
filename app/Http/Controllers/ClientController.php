<?php

namespace App\Http\Controllers;


class ClientController extends Controller
{
    public function completeClient(){
        return view('register.complete_client');
    }

    public function completeTrainer(){
        return view('register.complete_trainer');
    }
}