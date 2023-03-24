<?php

namespace App\Modules\Channel\Exceptions;

use Illuminate\Http\Response;
use Common\Exceptions\AbstractException;

class ExampleException extends AbstractException
{
    public function __construct($errorCode = "ERR_001")
    {
        parent::__construct($errorCode, Response::HTTP_FORBIDDEN);
    }
}
