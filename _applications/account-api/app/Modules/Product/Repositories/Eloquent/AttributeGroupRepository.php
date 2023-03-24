<?php

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Product\Repositories\Eloquent\AttributeGroupRepository as Repository;
use App\Modules\Product\Repositories\Contracts\AttributeGroupInterface;

/**
 * Class AttributeGroupRepository
 * @package App\Modules\Product\Repositories\Eloquent
 */
class AttributeGroupRepository extends Repository implements AttributeGroupInterface
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
