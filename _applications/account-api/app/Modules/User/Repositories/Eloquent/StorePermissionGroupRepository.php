<?php

namespace App\Modules\User\Repositories\Eloquent;

use AccountSdkDb\Modules\User\Repositories\Eloquent\StorePermissionGroupRepository as Repository;
use App\Modules\User\Repositories\Contracts\StorePermissionGroupInterface;

/**
 * Class StorePermissionGroupRepository
 * @package App\Modules\User\Repositories\Eloquent
 * @version December 3, 2021, 4:07 am UTC
 */
class StorePermissionGroupRepository extends Repository implements StorePermissionGroupInterface
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
