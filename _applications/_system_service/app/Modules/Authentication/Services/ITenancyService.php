<?php


namespace App\Modules\Authentication\Services;

/**
 * Interface ITenancyService
 * @package App\Modules\Authentication\Services
 */
interface ITenancyService
{
    /**
     * @param $userId
     * @return mixed
     */
    public function getCallbackUrlByUsername($userId);

}
