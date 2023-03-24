<?php

namespace App\Modules\Order\Repositories\Eloquent;

use OmSdk\Modules\Order\Repositories\Eloquent\OrderPaymentRepository as Repository;
use App\Modules\Order\Repositories\Contracts\IOrderPaymentRepository;

/**
 * Class OrderPaymentRepository
 * @package App\Modules\Order\Repositories\Eloquent
 */
class OrderPaymentRepository extends Repository implements IOrderPaymentRepository
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
