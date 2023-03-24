<?php

namespace App\Modules\User\Services;

/**
 * Service liên quan user
 * Interface IUserService
 * @package App\Modules\User\Services
 */
interface IUserService
{

    /**
     * Lấy danh sách user
     * @param string $keyword
     * @param numeric $limit
     * @param numeric $offset
     * @return mixed
     */
    public function search($keyword, $limit, $offset);

    /**
     * Lưu thông tin tạo mới user
     * @param array $payload
     * @return mixed
     */
    public function store($payload);

    /**
     * Lấy thông tin để tạo mới user
     * @return mixed
     */
    public function getCreateInfos();

    /**
     * Lấy chi tiết user
     * @param numeric $userId
     * @return mixed
     */
    public function show($userId);

    /**
     * Lưu thông tin cập nhật user
     * @param numeric $id
     * @param array $payload
     * @return mixed
     */
    public function update($id, $payload);

    /**
     * Thay đôi trạng thái user active_status
     * @param numeric $id
     * @param array $payload
     * @return mixed
     */
    public function updateStatus($id, $payload);

}