<?php

namespace App\Modules\Warehouse\Repositories\Eloquent;

use App\Modules\Warehouse\Repositories\Contracts\WarehouseStoreInterface;

/**
 * Class WarehouseStoreRepository
 * @package App\Modules\Warehouse\Repositories\Eloquent
 */
class WarehouseStoreRepository extends \AccountSdkDb\Modules\Warehouse\Repositories\Eloquent\WarehouseStoreRepository implements WarehouseStoreInterface
{

    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     */
    public function _prepareConditions($conditions, $query)
    {

        $query = parent::_prepareConditions($conditions, $query);
        if (isset($conditions['warehouse_id'])) {
            $warehouse_id = $conditions['warehouse_id'];
            $query->where('warehouse_id', $warehouse_id);
        }
        return $query;
    }

}
