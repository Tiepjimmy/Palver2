<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\RetailProductEntityPriceRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\RetailProductEntityPriceInterface;

/**
 * Class RetailProductEntityPriceRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class RetailProductEntityPriceRepository extends BaseRepository implements RetailProductEntityPriceInterface
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

        if (isset($conditions['product_entity_id'])) {
            $product_entity_id = $conditions['product_entity_id'];
            $query->where('product_entity_id', $product_entity_id);
        }

        return $query;
    }
}
