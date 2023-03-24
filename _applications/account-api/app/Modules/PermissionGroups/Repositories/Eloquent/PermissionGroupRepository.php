<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\PermissionGroups\Repositories\Eloquent;

use AccountSdkDb\Modules\User\Repositories\Eloquent\PermissionGroupRepository as BaseRepository;
use App\Modules\PermissionGroups\Repositories\Contracts\PermissionGroupInterface;

/**
 * Class PermissionGroupRepository
 * @package App\Modules\Example\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class PermissionGroupRepository extends BaseRepository implements PermissionGroupInterface
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

        if (isset($conditions['search'])) {
            $query->where(function($query) use ($conditions) {
                $search = $conditions['search'];
                $searchId = $conditions['search_id'];
                $query->where('group_name', 'LIKE', '%'.$search.'%')
                      ->orWhereIn('id', $searchId);
            });
        }

        return $query;
    }
}
