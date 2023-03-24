<?php

namespace App\Modules\Product\Controllers\Api;

use Illuminate\Http\Request;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Product\Services\IAttributeGroupService;

/**
 * Class AttributeGroupApiController
 * I/O cho AttributeGroup
 * @package App\Modules\Product\Controllers\Api
 */
class AttributeGroupApiController extends AbstractApiController
{
    private $attributeGroupService;

    /**
     * AttributeGroupApiController constructor.
     * @param IAttributeGroupService $attributeGroupService
     */
    public function __construct(
        IAttributeGroupService $attributeGroupService
    ) {
        parent::__construct();
        $this->attributeGroupService = $attributeGroupService;
    }

    /**
     * Lấy danh sách nhóm thuộc tính
     * @return mixed
     */
    public function index() {
        $listAttributeGroup = $this->attributeGroupService->getList();
        return $this->_responseSuccess('Xử lý thành công', $listAttributeGroup);
    }

    /**
     * Lấy thông tin để tạo mới nhóm thuộc tính
     * @return mixed
     */
    public function create()
    {
        $createInfo = $this->attributeGroupService->getCreateInfos();
        return $this->_responseSuccess('Xử lý thành công', $createInfo);
    }

    /**
     * Lưu thông tin tạo mới nhóm thuộc tính
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $storedAttributeGroup = $this->attributeGroupService->store($request->all());
        return $this->_responseSuccess('Xử lý thành công', $storedAttributeGroup);
    }

    /**
     * Lấy chi tiết nhóm thuộc tính
     * @param numeric $id
     * @return mixed
     */
    public function show($id)
    {
        $attributeGroup = $this->attributeGroupService->show($id);
        return $this->_responseSuccess('Xử lý thành công', $attributeGroup);
    }

    /**
     * Lưu thông tin cập nhật nhóm thuộc tính
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $updatedAttributeGroup = $this->attributeGroupService->update($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedAttributeGroup);
    }

    /**
     * Thay đổi trạng thái nhóm thuộc tính active_status
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function updateStatus($id, Request $request) {
        $updatedAttributeGroupStatus = $this->attributeGroupService->updateStatus($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedAttributeGroupStatus);
    }

}
