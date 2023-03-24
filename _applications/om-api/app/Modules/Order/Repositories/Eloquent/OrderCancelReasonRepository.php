<?php

namespace App\Modules\Order\Repositories\Eloquent;

use OmSdk\Modules\Order\Repositories\Eloquent\OrderCancelReasonRepository as Repository;
use App\Modules\Order\Repositories\Contracts\IOrderCancelReasonRepository;

/**
 * Class OrderCancelReasonRepository
 * @package App\Modules\Order\Repositories\Eloquent
 */
class OrderCancelReasonRepository extends Repository implements IOrderCancelReasonRepository
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['keyword'])) {
            $keyword = $conditions['keyword'];
            $query->where('code', 'like', "%{$keyword}%");
            $query->orWhere('content', 'like', "%{$keyword}%");
        }

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
