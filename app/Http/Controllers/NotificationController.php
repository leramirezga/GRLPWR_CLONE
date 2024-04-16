<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function get(){
        return Auth::user()->notifications;
    }

    public function read(){
        Auth::user()->unreadNotifications()->find(request()->id)->MarkAsRead();
    }
}
