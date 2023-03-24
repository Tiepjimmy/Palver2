<?php

namespace App\Modules\User\Repositories\Eloquent;

use AccountSdkDb\Modules\User\Repositories\Eloquent\AssignPermissionGroupRepository as Repository;
use App\Modules\User\Repositories\Contracts\AssignPermissionGroupInterface;

/**
 * Class AssignPermissionGroupRepository
 * @package App\Modules\User\Repositories\Eloquent
 * @version December 3, 2021, 4:07 am UTC
 */
class AssignPermissionGroupRepository extends Repository implements AssignPermissionGroupInterface
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['list_assign_id'])) {
            $listAssignId = $conditions['list_assign_id'];
            $query->whereIn('assign_id', $listAssignId);
        }

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
