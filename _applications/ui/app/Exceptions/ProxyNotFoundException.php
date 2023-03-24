<?php


namespace App\Exceptions;

use Common\Exceptions\AbstractException;
use Common\Exceptions\ErrorMessage;
use Illuminate\Http\Response;

/**
 * Class ProxyNotFoundException
 * @package App\Exceptions
 */
class ProxyNotFoundException extends AbstractException
{
    protected $statusCode = 400;
    protected $errorCode = 'ERR_001';
    public function __construct($message = null) {
        if(empty($message)){
            $message = ErrorMessage::ERR_001;
        }
        parent::__construct($this->errorCode, $message, $this->statusCode);
    }
}