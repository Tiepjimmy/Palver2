<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\PermissionGroups\Repositories\Eloquent;

use AccountSdkDb\Modules\Store\Repositories\Eloquent\StoreRepository as BaseRepository;
use App\Modules\PermissionGroups\Repositories\Contracts\StoreInterface;

/**
 * Class StoreRepository
 * @package App\Modules\Example\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class StoreRepository extends BaseRepository implements StoreInterface
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
