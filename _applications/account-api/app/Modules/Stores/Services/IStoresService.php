<?php


namespace App\Modules\Stores\Services;

/**
 * Stores Service
 * @package App\Modules\Stores\Services
 */
interface IStoresService
{
    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';

    /**
     * Thực hiện việc tìm kiếm tổ chức
     * @param mixed $attributes
     * @return mixed
     */
    public function search($attributes);

    /**
     * Thực hiện việc lấy các thông tin liên quan đến tổ chức
     * @return mixed
     */
    public function create();

    /**
     * Thêm mới tổ chức
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
     * cập nhật lại tổ chức
     * @param mixed $id
     * @param mixed $attributes
     * @return mixed
     */
    public function update($id,$attributes);

}