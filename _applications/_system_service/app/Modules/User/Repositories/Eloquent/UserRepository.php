<?php


namespace App\Modules\User\Repositories\Eloquent;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\SystemProjectEloquentRepository;
use Illuminate\Database\Query\Builder;

/**
 * Class UserRepository
 * @package App\Modules\Authentication\Repositories\Eloquent
 */
class UserRepository extends SystemProjectEloquentRepository implements UserRepositoryInterface
{
    /**
     * @return string
     */
    protected function _getModel()
    {
        return User::class;
    }

    /**
     * @param $conditions
     * @param $query
     * @return Builder
     */
    public function _prepareConditions($conditions, $query)
    {
        /** @var Builder $query */
        $query = parent::_prepareConditions($conditions, $query);
        if(isset($conditions['username'])){
            $query->where('username', '=', $conditions['username']);
        }
        return $query;
    }
    /**
     * @param $username
     * @param string[] $width
     * @return mixed
     */
    public function getUserByUsername($username, $width = ['TenancyContract'])
    {
        return $this->getOne(['username' => $username], $width);
    }
}
