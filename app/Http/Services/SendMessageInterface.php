<?php

namespace App\Http\Services;

use App\User;

interface SendMessageInterface
{
    public function sendMessage($info);
}