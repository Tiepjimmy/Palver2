<?php


namespace App\Modules\User\Controllers\Api;


use App\Modules\User\Services\IUserService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class UserController extends AbstractApiController
{
    protected $userService;
    public function __construct(IUserService $usersv)
    {
        $this->userService = $usersv;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request){
        $storeUser  = $this->userService->store($request->input());
        return $this->_responseSuccess('Xử lý thành công',$storeUser);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request) {
        $updateUser  = $this->userService->update($request->input());
        return $this->_responseSuccess('Xử lý thành công',$updateUser);
    }
}
