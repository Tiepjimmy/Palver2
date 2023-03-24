<?php


namespace App\Modules\PermissionGroups\Http;

/**
 * @package Pal\Commons\Http
 */
class PalServiceHttpStatusCode
{
    /***********************************************************************************************
     * 2xx                                                                                         *
     ***********************************************************************************************/
    /** @var int Trả về thành công cho những phương thức GET, PUT, PATCH hoặc DELETE. */
    CONST NO_ERROR = 200;

    /** @var int Trả về khi một Resouce vừa được tạo thành công. */
    CONST KHOI_TAO_THANH_CONG = 201;

    /** @var int Trả về khi Resource xoá thành công. */
    CONST NO_CONTENT = 204;

    /***********************************************************************************************
     * 3xx                                                                                         *
     ***********************************************************************************************/
    /** @var int Client có thể sử dụng dữ liệu cache. */
    CONST NOT_MODIFIED = 304;

    /***********************************************************************************************
     * 4xx                                                                                         *
     ***********************************************************************************************/
    /** @var int Request không hợp lệ, VALIDATOIN_ERROR */
    CONST BAD_REQUEST = 400;

    /** @var int Request cần có auth. */
    CONST UNAUTHEN = 401;

    /** @var int bị từ chối không cho phép. */
    CONST FORBIDDEN = 403;

    /** @var int Không tìm thấy resource từ URI */
    CONST NOT_FOUND = 404;

    /** @var int Phương thức không cho phép với user hiện tại. */
    CONST METHOD_NOT_ALLOWED = 405;

    /** @var int Resource không còn tồn tại, Version cũ đã không còn hỗ trợ. */
    CONST GONE = 410;

    /** @var int Không hỗ trợ kiểu Resource này. */
    CONST UNSUPPORTED_MEDIA_TYPE = 415;

    /** @var int  Unprocessable Entity */
    CONST UNPROCESSABLE_ENTITY = 422;

    /** @var int Request bị từ chối do bị giới hạn */
    CONST TOO_MANY_REQUESTS = 429;

    /***********************************************************************************************
     * 5xx                                                                                         *
     ***********************************************************************************************/
    /** @var int Lỗi hệ thống */
    CONST ERROR = 500;
}
