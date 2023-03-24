<?php


namespace App\Modules\Authentication\Repositories\Eloquent;


use App\Modules\Authentication\Models\TenancyContract;
use App\Modules\Authentication\Repositories\Contracts\TenancyContractRepositoryInterface;
use App\Repositories\SystemProjectEloquentRepository;

/**
 * Class UserRepository
 * @package App\Modules\Authentication\Repositories\Eloquent
 */
class TenancyContractRepository extends SystemProjectEloquentRepository implements TenancyContractRepositoryInterface
{
    protected function _getModel()
    {
        return TenancyContract::class;
    }
}
