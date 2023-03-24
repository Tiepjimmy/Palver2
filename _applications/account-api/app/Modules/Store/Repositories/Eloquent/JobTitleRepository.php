<?php

namespace App\Modules\Store\Repositories\Eloquent;

use AccountSdkDb\Modules\Store\Repositories\Eloquent\JobTitleRepository as Repository;
use App\Modules\Store\Repositories\Contracts\JobTitleInterface;

/**
 * Class JobTitleRepository
 * @package App\Modules\Store\Repositories\Eloquent
 */
class JobTitleRepository extends Repository implements JobTitleInterface
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
