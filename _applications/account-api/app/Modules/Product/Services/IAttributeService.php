<?php

namespace App\Modules\Product\Services;

/**
 * Service liên quan thuộc tính
 * Interface IAttributeService
 * @package App\Modules\Product\Services
 */
interface IAttributeService
{
    /**
     * Lấy thông tin để tạo mới thuộc tính
     * @return mixed
     */
    public function getCreateInfos();

    /**
     * Lưu thông tin tạo mới thuộc tính
     * @param array $payload
     * @return mixed
     */
    public function store($payload);

    /**
     * Lấy chi tiết thuộc tính
     * @param numeric $attributeGroupId
     * @return mixed
     */
    public function show($attributeGroupId);

    /**
     * Lưu thông tin cập nhật thuộc tính
     * @param numeric $attributeId
     * @param array $payload
     * @return mixed
     */
    public function update($attributeId, $payload);

    /**
     * Xóa thông tin thuộc tính
     * @param numeric $attributeId
     * @return mixed
     */
    public function destroy($attributeId);

    /**
     * Thay đôi trạng thái nhóm thuộc tính active_status
     * @param numeric $attributeId
     * @param array $payload
     * @return mixed
     */
    public function updateStatus($attributeId, $payload);

}