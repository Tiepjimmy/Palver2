<?php


namespace App\Modules\Authentication\Controllers\Api;


use App\Modules\Authentication\Services\IAuthService;
use App\Modules\Authentication\Services\IRoleService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * @package App\Modules\Authentication\Controllers\Api
 */
class LoginController extends AbstractApiController
{
    /**
     * @param Request $request
     * @param IAuthService $authService
     * @return mixed
     */
    public function index(Request $request, IAuthService $authService){
        $jwt = $authService->attempt($request['username'], $request['password'], $request['remember']);
        return $this->_responseSuccess('success', ['jwt' => $jwt]);
    }

    /**
     * @param Request $request
     * @param IRoleService $roleService
     * @return mixed
     */
    public function info(Request $request, IRoleService $roleService){
        if($request->has('has-role')){
            return $this->_responseSuccess('success', ['user' => Auth::user(), 'roles' => $roleService->getAllRoleOfUser()]);
        }else{
            return $this->_responseSuccess('success', ['user' => Auth::user()]);
        }
    }

}