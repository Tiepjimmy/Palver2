<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\StoreProductCatalogRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\StoreProductCatalogInterface;

/**
 * Class StoreProductCatalogRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class StoreProductCatalogRepository extends BaseRepository implements StoreProductCatalogInterface
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

        if (isset($conditions['store_id'])) {
            if (is_array($conditions['store_id'])) {
                $query->whereIn('store_id', $conditions['store_id']);
            } else {
                $query->where('store_id', $conditions['store_id']);
            }
        }

        return $query;
    }
}
