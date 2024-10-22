<?php

namespace App\Exceptions;


class ApiValidationException extends ApiException
{
    public function __construct(string $message = "message.validation_exception",int $code)
    {
        parent::__construct(__($message), $code);
    }
}
