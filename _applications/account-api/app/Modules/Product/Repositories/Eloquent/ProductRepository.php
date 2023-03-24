<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\ProductRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\ProductInterface;

/**
 * Class ProductRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class ProductRepository extends BaseRepository implements ProductInterface
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
                $query->where('product_name', 'LIKE', '%' . $conditions['search'] . '%')
                      ->orWhere('product_cd', 'LIKE', '%' . $conditions['search'] . '%');
            });
        }

        if (isset($conditions['product_type'])) {
            $query->where('product_type', $conditions['product_type']);
        }

        if (isset($conditions['product_catalog_id'])) {
            if (is_array($conditions['product_catalog_id'])) {
                $query->whereIn('product_catalog_id', $conditions['product_catalog_id']);
            } else {
                $query->where('product_catalog_id', $conditions['product_catalog_id']);
            }
        }

        return $query;
    }
}
