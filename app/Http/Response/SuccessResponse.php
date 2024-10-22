<?php

namespace App\Http\Response;

use InvalidArgumentException;

class SuccessResponse
{

    /**
     * @var int $code
     */
    private int $code;
    /**
     * @var string $message
     */
    private string $message;
    /**
     * @var string|array|object
     *
     */
    private string|array|object $data;


    public function __construct($message, $data,int $code)
    {
        $this->code=$code;
        $this->message=$message;

     if (!empty($data)){
         if (is_string($data))
         {
             $this->message=$data;
         }
         elseif (is_array($data)||is_object($data)){
             $this->data=$data;
         }
         else{
             throw new InvalidArgumentException('Data must be of type string, object or array');
         }
     }

    }
    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return get_object_vars($this);
    }

}
