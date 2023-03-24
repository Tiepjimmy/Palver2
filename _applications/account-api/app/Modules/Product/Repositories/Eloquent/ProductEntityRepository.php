<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\ProductEntityRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\ProductEntityInterface;

/**
 * Class ProductEntityRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class ProductEntityRepository extends BaseRepository implements ProductEntityInterface
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

        if (isset($conditions['search'])) {
            $query->leftJoin('acc_t_products', 'acc_t_products.id', '=', 'acc_t_product_entities.product_id');
            $query->where('acc_t_products.product_name', 'LIKE', '%' . $conditions['search'] . '%');
        }

        if (isset($conditions['idNotIn'])) {
            if (is_array($conditions['idNotIn'])) {
                $query->whereNotIn('id', $conditions['idNotIn']);
            }
        }

        if (isset($conditions['product_id'])) {
            $query->where('product_id', $conditions['product_id']);
        }

        if (isset($conditions['product_entity_cd'])) {
            $query->where('product_entity_cd', $conditions['product_entity_cd']);
        }

        return $query;
    }
}
