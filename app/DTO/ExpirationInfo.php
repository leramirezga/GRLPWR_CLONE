<?php

namespace App\DTO;

use Carbon\Carbon;

class ExpirationInfo
{
    public String $cellphone;
    public Carbon $expiration_date;
    public int $client_plan_id;

    public function __construct($cellphone, $expiration_date, $client_plan_id)
    {
        $this->client_plan_id= $client_plan_id;
        $this->cellphone = $cellphone;
        $this->expiration_date = $expiration_date;
    }
}