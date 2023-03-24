<?php

namespace App\Modules\Provider\Controllers\Api;

use Illuminate\Http\Request;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Provider\Services\IProviderService;

/**
 * Class ProviderApiController
 * @package App\Modules\User\Controllers\Api
 */
class ProviderApiController extends AbstractApiController
{
    private $providerService;

    public function __construct(
        IProviderService $providerService
    ) {
        parent::__construct();
        $this->providerService = $providerService;
    }

    /**
     * Lấy danh sách nhà cung cấp
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        $keyword = $request->filled('keyword') ? $request->input('keyword') : '';
        $limit = $request->filled('limit') && is_numeric($request->input('limit')) ? (int)$request->input('limit') : 10;
        $offset = $request->filled('offset') && is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        $searchResult = $this->providerService->search($keyword, $limit, $offset);
        return $this->_responseSuccess('Xử lý thành công', $searchResult);
    }

    /**
     * Lấy chi tiết nhà cung cấp
     * @param numeric $id
     * @return mixed
     */
    public function show($id)
    {
        $provider = $this->providerService->show($id);
        return $this->_responseSuccess('Xử lý thành công', $provider);
    }

    /**
     * Lấy thông tin để tạo mới nhà cung cấp
     * @return mixed
     */
    public function create()
    {
        $createInfo = $this->providerService->getCreateInfos();
        return $this->_responseSuccess('Xử lý thành công', $createInfo);
    }

    /**
     * Lưu thông tin tạo mới nhà cung cấp
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $storedProvider = $this->providerService->store($request->all());
        return $this->_responseSuccess('Xử lý thành công', $storedProvider);
    }

    /**
     * Lưu thông tin cập nhật nhà cung cấp
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $updatedProvider = $this->providerService->update($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedProvider);
    }

    /**
     * Thay đổi trạng thái nhà cung cấp active_status
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function updateStatus($id, Request $request) {
        $updatedProviderStatus = $this->providerService->updateStatus($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedProviderStatus);
    }

}
