<?php

namespace App\Modules\Product\Services;

/**
 * Service liên quan nhóm thuộc tính
 * Interface IAttributeGroupService
 * @package App\Modules\Product\Services
 */
interface IAttributeGroupService
{
    /**
     * Lấy danh sách nhóm thuộc tính
     * @return mixed
     */
    public function getList();

    /**
     * Lấy thông tin để tạo mới nhóm thuộc tính
     * @return mixed
     */
    public function getCreateInfos();

    /**
     * Lưu thông tin tạo mới nhóm thuộc tính
     * @param array $payload
     * @return mixed
     */
    public function store($payload);

    /**
     * Lấy chi tiết nhóm thuộc tính
     * @param numeric $attributeGroupId
     * @return mixed
     */
    public function show($attributeGroupId);

    /**
     * Lưu thông tin cập nhật nhóm thuộc tính
     * @param numeric $id
     * @param array $payload
     * @return mixed
     */
    public function update($id, $payload);

    /**
     * Thay đôi trạng thái nhóm thuộc tính active_status
     * @param numeric $attributeGroupId
     * @param array $payload
     * @return mixed
     */
    public function updateStatus($attributeGroupId, $payload);


}