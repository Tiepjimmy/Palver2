<?php

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\AttributeIntRepository as Repository;
use App\Modules\Product\Repositories\Contracts\AttributeIntInterface;

/**
 * Class AttributeIntRepository
 * @package App\Modules\Product\Repositories\Eloquent
 */
class AttributeIntRepository extends Repository implements AttributeIntInterface
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
