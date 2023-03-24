<?php


namespace App\Modules\Authentication\Controllers\Api;

use App\Modules\Authentication\Services\IRoleService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

/**
 * Class RoleController
 * @package App\Modules\Authentication\Controllers\Api
 */
class RoleController extends AbstractApiController
{
    /**
     * @param Request $request
     * @param IRoleService $roleService
     * @return mixed
     */
    public function index(Request $request, IRoleService $roleService){
        $storeAndRoles = $roleService->getAllRoleOfUser();
        $roles = [];
        foreach ($storeAndRoles as &$store){
            $roles = array_merge($roles, $store['permissions']);
            $store['permissions'] = array_column($store['permissions'], 'permission_cd');
        }
        $roles = array_unique($roles, SORT_REGULAR);
        return $this->_responseSuccess('Success', [
            'roles' => $roles,
            'stores' => $storeAndRoles
        ]);
    }

}