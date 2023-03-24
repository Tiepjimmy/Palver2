<?php

namespace App\Modules\Provider\Repositories\Eloquent;

use AccountSdkDb\Modules\Provider\Repositories\Eloquent\ProviderRepository as Repository;
use App\Modules\Provider\Repositories\Contracts\ProviderInterface;

/**
 * Class ProviderRepository
 * @package App\Modules\Provider\Repositories\Eloquent
 */
class ProviderRepository extends Repository implements ProviderInterface
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['keyword'])) {
            $keyword = $conditions['keyword'];
            $query->where('provider_name', 'like', "%{$keyword}%");
        }

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
