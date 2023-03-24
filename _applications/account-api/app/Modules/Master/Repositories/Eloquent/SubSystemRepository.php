<?php

namespace App\Modules\Master\Repositories\Eloquent;

use AccountSdkDb\Modules\Master\Repositories\Eloquent\SubSystemRepository as Repository;
use App\Modules\Master\Repositories\Contracts\SubSystemInterface;

/**
 * Class SubSystemRepository
 * @package App\Modules\Master\Repositories\Eloquent
 * @version December 3, 2021, 4:07 am UTC
 */

class SubSystemRepository extends Repository implements SubSystemInterface
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
