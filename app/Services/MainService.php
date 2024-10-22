<?php

namespace App\Services;

use JetBrains\PhpStorm\ArrayShape;

class MainService
{
    protected function createResponse($message, $status,$data): array
    {
        return [
            'message' => $message,
            'status'  => $status,
            'data'  => $data,
        ];
    }
}
