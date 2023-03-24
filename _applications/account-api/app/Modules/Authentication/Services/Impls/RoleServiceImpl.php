<?php


namespace App\Modules\Authentication\Services\Impls;

use AccountSdkDb\Modules\Master\Repositories\Contracts\PermissionInterface;
use AccountSdkDb\Modules\Store\Repositories\Contracts\StoreInterface;
use App\Modules\Authentication\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Authentication\Services\IRoleService;
use App\Modules\Stores\Services\IStoresService;
use Illuminate\Support\Facades\Auth;

/**
 * Class RoleServiceImpl
 * @package App\Modules\Authentication\Services\Impls
 */
class RoleServiceImpl implements IRoleService
{
    private $userRepository;
    private $storeRepository;
    private $permissionRepository;
    /**
     * RoleServiceImpl constructor.
     * @param UserRepositoryInterface $userRepository
     * @param StoreInterface $storeRepository
     * @param PermissionInterface $permissionRepository
     */
    public function __construct(UserRepositoryInterface $userRepository,
        StoreInterface $storeRepository,
        PermissionInterface $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->storeRepository = $storeRepository;
        $this->permissionRepository = $permissionRepository;

    }

    /**
     * @param null $userId
     * @return mixed
     */
    public function getAllRoleOfUser($userId = null)
    {
        if(!isset($userId)){
            $userId = Auth::id();
        }
        $user = $this->userRepository->getById(Auth::id());
        if(!$user->is_owner){
            return $this->getAllRoleOfNormalUser($userId);
        }
        $stores = $this->storeRepository->getAll()->toArray();
        $roles = $this->permissionRepository->getAll()->toArray();
        foreach ($stores as &$store){
            $store['permissions'] = $roles;
        }
        return $stores;
    }

    /**
     * @param $userId
     * @return mixed
     */
    private function getAllRoleOfNormalUser($userId){
        $roles = $this->userRepository->getRoleOfUser($userId);
        $storeIds = array_column($roles, 'store_id');
        $stores = $this->storeRepository->getMore(['list_store_id' => $storeIds])->toArray();
        foreach ($stores as &$store){
            $permissions = array_filter($roles, function($item) use ($store){
                return $store['id'] == $item['store_id'];
            });
            foreach ($permissions as &$permission){
                unset($permission['store_id']);
            }
            $store['permissions'] = $permissions;
        }
        return $stores;
    }
}