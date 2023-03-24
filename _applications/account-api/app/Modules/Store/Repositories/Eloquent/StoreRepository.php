<?php

namespace App\Modules\Store\Repositories\Eloquent;

use AccountSdkDb\Modules\Store\Repositories\Eloquent\StoreRepository as Repository;
use App\Modules\Store\Repositories\Contracts\StoreInterface;

/**
 * Class StoreRepository
 * @package App\Modules\Store\Repositories\Eloquent
 */
class StoreRepository extends Repository implements StoreInterface
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
