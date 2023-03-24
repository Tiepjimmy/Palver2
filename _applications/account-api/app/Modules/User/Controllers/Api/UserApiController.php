<?php

namespace App\Modules\User\Controllers\Api;

use Illuminate\Http\Request;
use App\Modules\User\Services\IUserService;
use Common\Http\Controllers\Api\AbstractApiController;

/**
 * Class UserApiController
 * I/O cho users
 * @package App\Modules\User\Controllers\Api
 */
class UserApiController extends AbstractApiController
{
    private $userService;

    /**
     * UserApiController constructor.
     * @param IUserService $userService
     */
    public function __construct(
        IUserService $userService
    ) {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * lấy danh sách user
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        $keyword = $request->filled('keyword') ? $request->input('keyword') : '';
        $limit = $request->filled('limit') && is_numeric($request->input('limit')) ? (int)$request->input('limit') : 10;
        $offset = $request->filled('offset') && is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        $searchResult = $this->userService->search($keyword, $limit, $offset);
        return $this->_responseSuccess('Xử lý thành công', $searchResult);
    }

    /**
     * Lấy thông tin để tạo mới user
     * @return mixed
     */
    public function create()
    {
        $createInfo = $this->userService->getCreateInfos();
        return $this->_responseSuccess('Xử lý thành công', $createInfo);
    }

    /**
     * Lưu thông tin tạo mới user
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $storedUser = $this->userService->store($request->all());
        return $this->_responseSuccess('Xử lý thành công', $storedUser);
    }

    /**
     * Lấy chi tiết user
     * @param numeric $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->userService->show($id);
        return $this->_responseSuccess('Xử lý thành công', $user);
    }

    /**
     * Lưu thông tin cập nhật user
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $updatedUser = $this->userService->update($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedUser);
    }

    /**
     * Thay đổi trạng thái user active_status
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function updateStatus($id, Request $request) {
        $updatedUserStatus = $this->userService->updateStatus($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedUserStatus);
    }

}
