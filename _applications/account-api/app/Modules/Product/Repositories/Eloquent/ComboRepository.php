<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\ComboRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\ComboInterface;

/**
 * Class ComboRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class ComboRepository extends BaseRepository implements ComboInterface
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
            $product_id = $conditions['product_id'];
            $query->where('product_id', $product_id);
        }

        return $query;
    }
}
