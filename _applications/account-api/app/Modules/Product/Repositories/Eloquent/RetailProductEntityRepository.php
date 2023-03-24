<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\RetailProductEntityRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\RetailProductEntityInterface;

/**
 * Class RetailProductEntityRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class RetailProductEntityRepository extends BaseRepository implements RetailProductEntityInterface
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

        if (isset($conditions['product_entity_cd'])) {
            $query->leftJoin('acc_t_product_entities', 'acc_t_product_entities.id', '=', 'acc_t_retail_product_entities.product_entity_id');
            $query->where('acc_t_product_entities.product_entity_cd', $conditions['product_entity_cd']);
        }

        if (isset($conditions['idNotIn'])) {
            if (is_array($conditions['idNotIn'])) {
                $query->whereNotIn('id', $conditions['idNotIn']);
            }
        }

        if (isset($conditions['product_id'])) {
            $query->where('product_id', $conditions['product_id']);
        }

        return $query;
    }
}
