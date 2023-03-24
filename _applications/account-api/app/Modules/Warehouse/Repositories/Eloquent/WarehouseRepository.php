<?php

namespace App\Modules\Warehouse\Repositories\Eloquent;

use AccountSdkDb\Modules\Warehouse\Models\Warehouse;
use App\Modules\Warehouse\Repositories\Contracts\WarehouseInterface;

/**
 * Class WarehouseRepository
 * @package App\Modules\Warehouse\Repositories\Eloquent
 */
class WarehouseRepository extends \AccountSdkDb\Modules\Warehouse\Repositories\Eloquent\WarehouseRepository implements WarehouseInterface
{

    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['keyword'])) {
            $keyword = $conditions['keyword'];
            $query->where('warehouse_name', 'like', "{$keyword}%");
            $query->orWhere('warehouse_cd', 'like', "{$keyword}%");
            $query->orWhere('address', 'like', "{$keyword}%");
        }

//        if (isset($conditions['active_status'])) {
//            $name = normalizer_normalize($conditions['name']);
//            if ($name) $query->where('name', 'like', '%'.$name.'%');
//        }

        return $query;
    }
    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        if (isset($fetchOptions['limit'])) {
            $limit = $fetchOptions['limit'];
            $query->distinct();
            $query->limit($limit);
        }

        if (isset($fetchOptions['offset'])) {
            $offset = $fetchOptions['offset'];
            $query->offset($offset);
        }

        return $query;
    }

    public function rules()
    {
        return Warehouse::$rules;
    }
}
