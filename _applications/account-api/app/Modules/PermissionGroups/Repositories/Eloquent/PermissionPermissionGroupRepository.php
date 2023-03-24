<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\PermissionGroups\Repositories\Eloquent;

use AccountSdkDb\Modules\User\Repositories\Eloquent\PermissionPermissionGroupRepository as BaseRepository;
use App\Modules\PermissionGroups\Repositories\Contracts\PermissionPermissionGroupInterface;

/**
 * Class PermissionPermissionGroupRepository
 * @package App\Modules\Example\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class PermissionPermissionGroupRepository extends BaseRepository implements PermissionPermissionGroupInterface
{
    /**
     * @param array $conditions
     * @param mixed $query
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['permission_group_id'])) {
            $permission_group_id = $conditions['permission_group_id'];
            $query->where('permission_group_id', $permission_group_id);
        }

        return $query;
    }
}
