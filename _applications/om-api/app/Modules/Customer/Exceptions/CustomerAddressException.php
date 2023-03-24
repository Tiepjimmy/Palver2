<?php

namespace App\Modules\Customer\Exceptions;

use Illuminate\Http\Response;
use Common\Exceptions\AbstractException;

class CustomerAddressException extends AbstractException
{
    public function __construct($errorCode = "ERR_001")
    {
        $constant = '\App\Exceptions\ErrorMessage::' . $errorCode;
        $message  = defined($constant) ? constant($constant) : \App\Exceptions\ErrorMessage::ERR_001;

        parent::__construct($errorCode, $message, Response::HTTP_FORBIDDEN);
    }
}
