<?php

namespace App\Modules\Store\Services;

/**
 * Service liên quan chức danh
 * Interface IJobTitleService
 * @package App\Modules\Provider\Services
 */
interface IJobTitleService
{
    /**
     * Tìm kiếm danh sách chức danh
     * @param string $keyword
     * @param numeric $limit
     * @param numeric $offset
     * @return mixed
     */
    public function search($keyword, $limit, $offset);

    /**
     * Lấy thông tin để tạo mới chức danh
     * @return mixed
     */
    public function getCreateInfo();

    /**
     * Lưu thông tin tạo mới chức danh
     * @param array $payload
     * @return mixed
     */
    public function store($payload);

    /**
     * lưu thông tin cập nhật chức danh
     * @param numeric $attributeId
     * @param array $payload
     * @return mixed
     */
    public function update($attributeId, $payload);

}