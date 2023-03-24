<?php


namespace App\Modules\Authentication\Services;

/**
 * Interface IAuthService
 * @package App\Modules\Authentication\Services
 */
interface IAuthService
{

    /**
     * Kiểm tra thông tin user/password
     * Trả về JWT nếu như đúng thông tin đăng nhập
     * Trả về null nếu như thông tin đăng nhập không đúng
     * @param $username
     * @param $password
     * @param $remember
     * @return string|null
     */
    public function attempt($username, $password, $remember = false);

}