<?php


namespace App\Modules\Authentication\Repositories\Contracts;

use Common\Repositories\Contracts\AbstractEloquentInterface;

/**
 * Interface UserRepositoryInterface
 * @package App\Modules\Authentication\Repositories\Contracts
 */
interface UserRepositoryInterface extends AbstractEloquentInterface
{
    /**
     * @param $username
     * @return mixed
     */
    public function getUserByUsername($username);

    /**
     * @return mixed
     */
    public function getRoleOfUser($userId);
}