<?php


namespace App\Modules\Authentication\Services;

/**
 * Interface IRoleService
 * @package App\Modules\Authentication\Services
 */
interface IRoleService
{

    /**
     * @param null $userId
     * @return mixed
     */
    public function getAllRoleOfUser($userId = null);

}