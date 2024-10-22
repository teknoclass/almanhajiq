<?php

namespace App\Http\Response;

class ErrorResponse
{
    /**
     * @var int $code
     */
    private int $code;

    /**
     * @var array $error
     */
    private array $error;


    /**
     * ErrorResponse constructor.
     *
     * @param string $message
     * @param int $code
     * @param array $errors
     */
    public function __construct(string $message, int $code, array $errors = [])
    {
        $this->code = $code;


        if (!empty($errors)) {

            $firstError = reset($errors);
            $this->error = [
                'message'   => is_array($firstError) ? reset($firstError) : $firstError,
            ];
        } else {

            $this->error = ['message' => $message];
        }
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return [
            'code' => $this->code,
            'error' => $this->error,
        ];
    }
}
