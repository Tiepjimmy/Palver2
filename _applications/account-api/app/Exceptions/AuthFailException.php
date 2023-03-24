<?php


namespace App\Exceptions;


use Common\Exceptions\PalException;
use Illuminate\Http\Response;

/**
 * Class AuthFailException
 * @package App\Exceptions
 */
class AuthFailException extends PalException
{
    /**
     * AuthFailException constructor.
     * @param string $message
     */
    public function __construct($message = 'Tên đăng nhập hoặc mật khẩu sai')
    {
        parent::__construct('E010001', $message, Response::HTTP_BAD_REQUEST);
    }

}