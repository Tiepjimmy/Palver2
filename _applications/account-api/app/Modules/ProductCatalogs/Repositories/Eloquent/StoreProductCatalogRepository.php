<?php

namespace App\Modules\ProductCatalogs\Repositories\Eloquent;

use App\Modules\ProductCatalogs\Repositories\Contracts\StoreProductCatalogInterface;

/**
 * Class StoreProductCatalogRepository
 * @package App\Modules\ProductCatalogs\Repositories\Eloquent
 */
class StoreProductCatalogRepository extends \AccountSdkDb\Modules\Product\Repositories\Eloquent\StoreProductCatalogRepository implements StoreProductCatalogInterface
{
    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);
        if (isset($conditions['product_catalog_id'])) {
            $parent_id = $conditions['product_catalog_id'];
            $query->where('product_catalog_id', $parent_id);
        }

//        if (isset($conditions['active_status'])) {
//            $name = normalizer_normalize($conditions['name']);
//            if ($name) $query->where('name', 'like', '%'.$name.'%');
//        }

        return $query;
    }

}
