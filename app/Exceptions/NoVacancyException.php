<?php

namespace App\Exceptions;

use App\Utils\Response;
use Exception;

class NoVacancyException extends Exception
{
    protected $message = 'Los cupos están llenos, pero puedes reservar tu cupo para la siguiente clase';
    protected $code = Response::NO_VACANCY;

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $this->getMessage()], $this->getCode());
        }

        return parent::render($request);
    }
}