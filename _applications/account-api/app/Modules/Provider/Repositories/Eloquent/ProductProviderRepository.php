<?php

namespace App\Modules\Provider\Repositories\Eloquent;

use AccountSdkDb\Modules\Provider\Repositories\Eloquent\ProductProviderRepository as Repository;
use App\Modules\Provider\Repositories\Contracts\ProductProviderInterface;

/**
 * Class ProductProviderRepository
 * @package App\Modules\Provider\Repositories\Eloquent
 */
class ProductProviderRepository extends Repository implements ProductProviderInterface
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
