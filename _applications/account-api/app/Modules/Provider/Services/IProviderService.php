<?php

namespace App\Modules\Provider\Services;

/**
 * Service liên quan nhà cung cấp
 * Interface IProviderService
 * @package App\Modules\Provider\Services
 */
interface IProviderService
{
    /**
     * Lấy danh sách nhà cung cấp
     * @param string $keyword
     * @param numeric $limit
     * @param numeric $offset
     * @return mixed
     */
    public function search($keyword, $limit, $offset);

    /**
     * Lấy chi tiết nhà cung cấp
     * @param numeric $providerId
     * @return mixed
     */
    public function show($providerId);

    /**
     * Lấy thông tin để tạo mới nhà cung cấp
     * @return mixed
     */
    public function getCreateInfos();

    /**
     * Lưu thông tin tạo mới nhà cung cấp
     * @param array $payload
     * @return mixed
     */
    public function store($payload);

    /**
     * Lưu thông tin cập nhật nhà cung cấp
     * @param numeric $id
     * @param array $payload
     * @return mixed
     */
    public function update($id, $payload);

    /**
     * Thay đôi trạng thái nhà cung cấp active_status
     * @param numeric $id
     * @param array $payload
     * @return mixed
     */
    public function updateStatus($id, $payload);

    /**
     * Lưu thông tin tạo mới nhóm nhà cung cấp
     * @param array $payload
     * @return mixed
     */
    public function storeProviderGroup($payload);

}