<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Provider\Repositories\Eloquent\ProductProviderRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\ProductProviderInterface;

/**
 * Class ProductProviderRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class ProductProviderRepository extends BaseRepository implements ProductProviderInterface
{
    /**
     * Mô tả method
     * @param array $conditions
     * @return mixed
     */
    public function deleteMore($conditions = array())
    {
        $query = $this->_model->newQuery();
        $query = $this->_prepareConditions($conditions, $query);

        return $query->delete();
    }

    /**
     * @param array $conditions
     * @param mixed $query
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['product_id'])) {
            $query->where('product_id', $conditions['product_id']);
        }

        return $query;
    }
}
