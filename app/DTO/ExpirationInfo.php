<?php

namespace App\DTO;

use Carbon\Carbon;

class ExpirationInfo
{
    public String $cellphone;
    public Carbon $expiration_date;

    public function __construct($cellphone, $expiration_date)
    {
        $this->cellphone = $cellphone;
        $this->expiration_date = $expiration_date;
    }
}