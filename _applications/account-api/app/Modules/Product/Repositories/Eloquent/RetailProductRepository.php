<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\RetailProductRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\RetailProductInterface;

/**
 * Class RetailProductRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class RetailProductRepository extends BaseRepository implements RetailProductInterface
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

        return $query;
    }
}
