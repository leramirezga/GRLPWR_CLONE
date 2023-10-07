<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ShoeSizeNotSupportedException extends Exception
{
    protected $message = 'Tamaño de zapato no soportado.';
    protected $code = Response::HTTP_BAD_REQUEST;

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $this->getMessage()], $this->getCode());
        }

        return parent::render($request);
    }
}