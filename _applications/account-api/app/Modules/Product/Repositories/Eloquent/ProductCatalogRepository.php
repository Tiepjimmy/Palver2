<?php

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\ProductCatalogRepository as Repository;
use App\Modules\Product\Repositories\Contracts\ProductCatalogInterface;

/**
 * Class ProductCatalogRepository
 * @package App\Modules\Product\Repositories\Eloquent
 */
class ProductCatalogRepository extends Repository implements ProductCatalogInterface
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['active_status'])) {
            $active_status = $conditions['active_status'];
            $query->where('active_status', $active_status);
        }

        if (isset($conditions['product_catalog_name'])) {
            $query->where('product_catalog_name', $conditions['product_catalog_name']);
        }

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
