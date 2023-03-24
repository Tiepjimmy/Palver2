<?php

namespace App\Modules\Stores\Repositories\Eloquent;

use AccountSdkDb\Modules\Store\Models\Store;
use AccountSdkDb\Modules\Store\Repositories\Eloquent\StoreRepository;
use App\Modules\Stores\Repositories\Contracts\StoresInterface;

/**
 * Class StoresRepository
 * @package App\Modules\Stores\Repositories\Eloquent
 */
class StoresRepository extends StoreRepository implements StoresInterface
{

    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);
        if (isset($conditions['parent_id'])) {
            $parent_id = $conditions['parent_id'];
            $query->where('parent_id', $parent_id);
        }
        if (isset($conditions['active_status'])) {
            $status = $conditions['active_status'];
            $query->where('active_status', $status);
        }

//        if (isset($conditions['active_status'])) {
//            $name = normalizer_normalize($conditions['name']);
//            if ($name) $query->where('name', 'like', '%'.$name.'%');
//        }

        return $query;
    }

    public function rules()
    {
        return Store::$rules;
    }
}
