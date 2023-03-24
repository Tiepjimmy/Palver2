<?php

namespace App\Modules\Provider\Repositories\Eloquent;

use AccountSdkDb\Modules\Provider\Repositories\Eloquent\ProviderGroupRepository as Repository;
use App\Modules\Provider\Repositories\Contracts\ProviderGroupInterface;

/**
 * Class ProviderGroupRepository
 * @package App\Modules\Provider\Repositories\Eloquent
 */
class ProviderGroupRepository extends Repository implements ProviderGroupInterface
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['list_store_id'])) {
            $listStoreId = $conditions['list_store_id'];
            $query->whereIn('store_id', $listStoreId);
        }

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
