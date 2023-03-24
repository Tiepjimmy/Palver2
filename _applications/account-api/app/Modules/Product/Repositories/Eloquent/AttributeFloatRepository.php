<?php

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\AttributeFloatRepository as Repository;
use App\Modules\Product\Repositories\Contracts\AttributeFloatInterface;

/**
 * Class AttributeFloatRepository
 * @package App\Modules\Product\Repositories\Eloquent
 */
class AttributeFloatRepository extends Repository implements AttributeFloatInterface
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
