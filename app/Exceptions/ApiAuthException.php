<?php


namespace App\Exceptions;

class ApiAuthException extends ApiException
{
    public function __construct(string $message = "message.auth_exception",int $code)
    {
        parent::__construct(__($message), $code);
    }
}
