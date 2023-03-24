<?php


namespace App\Modules\Authentication\Repositories\Eloquent;

use \AccountSdkDb\Modules\User\Repositories\Eloquent\UserRepository as Base;
use App\Modules\Authentication\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Query\Builder;

/**
 * Class UserRepository
 * @package App\Modules\Authentication\Repositories\Eloquent
 */
class UserRepository extends Base implements UserRepositoryInterface
{
    /**
     * @param $conditions
     * @param $query
     * @return mixed
     */
    protected function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);
        if (isset($conditions['username'])) {
            $query->where('username', 'like', $conditions['username']);
        }
        return $query;
    }

    /**
     * @param $username
     * @return mixed|void
     */
    public function getUserByUsername($username)
    {
        return $this->getOne(['username' => $username]);
    }

    /**
     * @param $userId
     * @return mixed|void
     */
    public function getRoleOfUser($userId)
    {
        $query = $this->_model->newQuery();
        $query->distinct();
        $query->join('acc_t_assigns', 'acc_t_assigns.user_id', '=', 'acc_t_users.id');
        $query->join('acc_t_assign_permission_group', 'acc_t_assign_permission_group.assign_id', '=', 'acc_t_assigns.id');
        $query->join('acc_t_permission_groups', 'acc_t_permission_groups.id', '=', 'acc_t_assign_permission_group.permission_group_id');
        $query->join('acc_t_permission_permission_group', 'acc_t_permission_permission_group.permission_group_id', '=', 'acc_t_permission_groups.id');
        $query->join('acc_m_permissions', 'acc_m_permissions.id', '=', 'acc_t_permission_permission_group.permission_id');
        $query->where('acc_t_users.id', '=', $userId);
        return $query->get(['acc_m_permissions.*', 'acc_t_assigns.store_id'])->toArray();
    }
}