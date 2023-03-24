<?php

namespace App\Modules\Provider\Repositories\Eloquent;

use AccountSdkDb\Modules\Provider\Repositories\Eloquent\ProviderProviderGroupRepository as Repository;
use App\Modules\Provider\Repositories\Contracts\ProviderProviderGroupInterface;

/**
 * Class ProviderProviderGroupRepository
 * @package App\Modules\Provider\Repositories\Eloquent
 */
class ProviderProviderGroupRepository extends Repository implements ProviderProviderGroupInterface
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['provider_id'])) {
            $providerId = $conditions['provider_id'];
            $query->where('provider_id', '=', $providerId);
        }

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
