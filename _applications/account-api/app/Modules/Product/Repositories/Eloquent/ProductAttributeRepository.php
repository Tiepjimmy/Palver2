<?php

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\ProductAttributeRepository as Repository;
use App\Modules\Product\Repositories\Contracts\ProductAttributeInterface;

/**
 * Class ProductAttributeRepository
 * @package App\Modules\Product\Repositories\Eloquent
 */
class ProductAttributeRepository extends Repository implements ProductAttributeInterface
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
