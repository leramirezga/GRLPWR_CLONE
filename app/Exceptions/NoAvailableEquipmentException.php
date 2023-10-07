<?php

namespace App\Exceptions;

use App\Utils\Response;
use Exception;

class NoAvailableEquipmentException extends Exception
{
    protected $message = 'No tenemos más equipos para alquilar, pero puedes reservar para la siguiente clase';
    protected $code = Response::NO_AVAILABLE_EQUIPMENT;

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $this->getMessage()], $this->getCode());
        }

        return parent::render($request);
    }
}