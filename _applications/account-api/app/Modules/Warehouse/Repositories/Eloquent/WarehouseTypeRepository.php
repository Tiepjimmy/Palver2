<?php

namespace App\Modules\Warehouse\Repositories\Eloquent;

use App\Modules\Warehouse\Repositories\Contracts\WarehouseTypeInterface;

/**
 * Class WarehouseTypeRepository
 * @package App\Modules\Warehouse\Repositories\Eloquent
 */
class WarehouseTypeRepository extends \AccountSdkDb\Modules\Master\Repositories\Eloquent\WarehouseTypeRepository implements WarehouseTypeInterface
{

    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);
        return $query;
    }
}
