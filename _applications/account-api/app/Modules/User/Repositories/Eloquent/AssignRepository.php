<?php

namespace App\Modules\User\Repositories\Eloquent;

use AccountSdkDb\Modules\User\Repositories\Eloquent\AssignRepository as Repository;
use App\Modules\User\Repositories\Contracts\AssignInterface;

/**
 * Class AssignRepository
 * @package App\Modules\User\Repositories\Eloquent
 * @version December 3, 2021, 4:07 am UTC
 */
class AssignRepository extends Repository implements AssignInterface
{
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        if (isset($conditions['user_id'])) {
            $userId = $conditions['user_id'];
            $query->where('user_id', '=', $userId);
        }

        return $query;
    }

    protected function _prepareFetchOptions($fetchOptions, $query)
    {
        $query = parent::_prepareFetchOptions($fetchOptions, $query);

        return $query;
    }
}
