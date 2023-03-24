<?php

namespace App\Modules\Store\Controllers\Api;

use Illuminate\Http\Request;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Store\Services\IJobTitleService;

/**
 * Class JobTitleApiController
 * @package App\Modules\Store\Controllers\Api
 */
class JobTitleApiController extends AbstractApiController
{
    private $jobTitleService;

    /**
     * JobTitleApiController constructor.
     * @param IJobTitleService $jobTitleService
     */
    public function __construct(
        IJobTitleService $jobTitleService
    ) {
        parent::__construct();
        $this->jobTitleService = $jobTitleService;
    }

    /**
     * Tìm kiếm danh sách chức danh
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        $keyword = $request->filled('keyword') ? $request->input('keyword') : '';
        $limit = $request->filled('limit') && is_numeric($request->input('limit')) ? (int)$request->input('limit') : 6;
        $offset = $request->filled('offset') && is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        $searchResult = $this->jobTitleService->search($keyword, $limit, $offset);
        return $this->_responseSuccess('Xử lý thành công', $searchResult);
    }

    /**
     * Lấy thông tin để tạo mới chức danh
     * @return mixed
     */
    public function create()
    {
        $createInfo = $this->jobTitleService->getCreateInfo();
        return $this->_responseSuccess('Xử lý thành công', $createInfo);
    }

    /**
     * Lưu thông tin tạo mới chức danh
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $storedJobTitle = $this->jobTitleService->store($request->all());
        return $this->_responseSuccess('Xử lý thành công', $storedJobTitle);
    }

    /**
     * lưu thông tin cập nhật chức danh
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $attributeJobTitle = $this->jobTitleService->update($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $attributeJobTitle);
    }

}
