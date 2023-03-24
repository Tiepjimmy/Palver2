<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Common\Exceptions\AbstractException;

class ShopInvalidException extends AbstractException
{
    public function __construct($message = '', $statusCode = null)
    {
        $message = 'Shop Invalid!';
        $statusCode = Response::HTTP_FORBIDDEN;
        parent::__construct($message, $statusCode);
    }
}
