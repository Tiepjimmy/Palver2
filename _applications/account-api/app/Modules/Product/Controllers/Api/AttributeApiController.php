<?php

namespace App\Modules\Product\Controllers\Api;

use Illuminate\Http\Request;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Product\Services\IAttributeService;

/**
 * Class AttributeApiController
 * I/O cho Attribute
 * @package App\Modules\Product\Controllers\Api
 */
class AttributeApiController extends AbstractApiController
{
    private $attributeService;

    /**
     * AttributeApiController constructor.
     * @param IAttributeService $attributeService
     */
    public function __construct(
        IAttributeService $attributeService
    ) {
        parent::__construct();
        $this->attributeService = $attributeService;
    }

    /**
     * Lưu thông tin tạo mới thuộc tính
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $storedAttribute = $this->attributeService->store($request->all());
        return $this->_responseSuccess('Xử lý thành công', $storedAttribute);
    }

    /**
     * Lưu thông tin cập nhật thuộc tính
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $updatedAttribute = $this->attributeService->update($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedAttribute);
    }

    /**
     * Xóa thuộc tính
     * @param numeric $id
     * @return mixed
     */
    public function destroy($id) {
        $destroyedAttribute = $this->attributeService->destroy($id);
        return $this->_responseSuccess('Xử lý thành công', $destroyedAttribute);
    }

    /**
     * Thay đổi trạng thái thuộc tính active_status
     * @param numeric $id
     * @param Request $request
     * @return mixed
     */
    public function updateStatus($id, Request $request) {
        $updatedAttributeStatus = $this->attributeService->updateStatus($id, $request->all());
        return $this->_responseSuccess('Xử lý thành công', $updatedAttributeStatus);
    }

}
