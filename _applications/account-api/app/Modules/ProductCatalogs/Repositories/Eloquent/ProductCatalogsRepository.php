<?php

namespace App\Modules\ProductCatalogs\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Models\ProductCatalog;
use AccountSdkDb\Modules\Product\Repositories\Eloquent\ProductCatalogRepository;
use App\Modules\ProductCatalogs\Repositories\Contracts\ProductCatalogsInterface;

/**
 * Class ProductCatalogsRepository
 * @package App\Modules\ProductCatalogs\Repositories\Eloquent
 */
class ProductCatalogsRepository extends ProductCatalogRepository implements ProductCatalogsInterface
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
        return ProductCatalog::$rules;
    }
}
