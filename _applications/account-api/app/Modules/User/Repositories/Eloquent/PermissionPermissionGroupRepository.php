<?php

namespace App\Modules\User\Repositories\Eloquent;

use AccountSdkDb\Modules\User\Repositories\Eloquent\PermissionPermissionGroupRepository as Repository;
use App\Modules\User\Repositories\Contracts\PermissionPermissionGroupInterface;

/**
 * Class PermissionPermissionGroupRepository
 * @package App\Modules\User\Repositories\Eloquent
 * @version December 3, 2021, 4:07 am UTC
 */
class PermissionPermissionGroupRepository extends Repository implements PermissionPermissionGroupInterface
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
