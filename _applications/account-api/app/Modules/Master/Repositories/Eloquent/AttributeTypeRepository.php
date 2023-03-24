<?php

namespace App\Modules\Master\Repositories\Eloquent;

use AccountSdkDb\Modules\Master\Repositories\Eloquent\AttributeTypeRepository as Repository;
use App\Modules\Master\Repositories\Contracts\AttributeTypeInterface;

/**
 * Class AttributeTypeRepository
 * @package App\Modules\Master\Repositories\Eloquent
 */
class AttributeTypeRepository extends Repository implements AttributeTypeInterface
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
