<?php

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\ProductCatalogAttributeGroupRepository as Repository;
use App\Modules\Product\Repositories\Contracts\ProductCatalogAttributeGroupInterface;

/**
 * Class ProductCatalogAttributeGroupRepository
 * @package App\Modules\Product\Repositories\Eloquent
 */
class ProductCatalogAttributeGroupRepository extends Repository implements ProductCatalogAttributeGroupInterface
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
