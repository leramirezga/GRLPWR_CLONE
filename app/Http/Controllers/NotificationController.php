<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
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
