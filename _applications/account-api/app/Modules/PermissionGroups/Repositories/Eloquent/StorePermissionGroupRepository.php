<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\PermissionGroups\Repositories\Eloquent;

use AccountSdkDb\Modules\User\Repositories\Eloquent\StorePermissionGroupRepository as BaseRepository;
use App\Modules\PermissionGroups\Repositories\Contracts\StorePermissionGroupInterface;

/**
 * Class StorePermissionGroupRepository
 * @package App\Modules\Example\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class StorePermissionGroupRepository extends BaseRepository implements StorePermissionGroupInterface
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

        if (isset($conditions['search'])) {
            $search = $conditions['search'];
            $query->leftJoin('acc_t_stores', 'acc_t_stores.id', '=', 'acc_t_store_permission_group.store_id');
            $query->where('store_name', 'LIKE', '%'.$search.'%');
        }

        return $query;
    }
}
