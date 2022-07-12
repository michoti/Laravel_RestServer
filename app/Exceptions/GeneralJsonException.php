<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    public function report()
    {
        
    }

    public function render()
    {
        return new JsonResponse([
            'errors' => $this->getMessage(),
        ], $this->getCode());
    }
}
