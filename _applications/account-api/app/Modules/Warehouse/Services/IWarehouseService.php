<?php


namespace App\Modules\Warehouse\Services;

/**
 * Warehouse Service
 * @package App\Modules\Warehouse\Services
 */
interface IWarehouseService
{
    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';

    /**
     * Thực hiện việc tìm kiếm kho
     * @param mixed $attributes
     * @return mixed
     */
    public function search($attributes);

    /**
     * Thực hiện việc lấy các thông tin liên quan đến Kho
     * @return mixed
     */
    public function create();

    /**
     * Thêm mới Kho
     * @param mixed $attributes
     * @return mixed
     */
    public function store($attributes);

    /**
     * Lấy thông tin chi tiết
     * @param mixed $id
     * @return mixed
     */
    public function get($id);

    /**
     * cập nhật lại Kho
     * @param mixed $id
     * @param mixed $attributes
     * @return mixed
     */
    public function update($id,$attributes);

}