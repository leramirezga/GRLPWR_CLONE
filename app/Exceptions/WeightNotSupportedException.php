<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class WeightNotSupportedException extends Exception
{
    protected $message = 'Hay un problema con el formato del peso, verifica que colocaste un valor valido, en kilogramos y sin decimales';
    protected $code = Response::HTTP_BAD_REQUEST;

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $this->getMessage()], $this->getCode());
        }

        return parent::render($request);
    }
}