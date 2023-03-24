<?php


namespace App\Modules\Product\Services;

/**
 * Product Service
 * @package App\Modules\Product\Services
 */
interface IProductServices
{
        
    /**
     * Lấy chuẩn hóa sản phẩm theo id sản phẩm
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Tìm kiếm chuẩn hóa sản phẩm
     *
     * @param  array $request
     * @return array
     */
    public function search($request);

    /**
     * Tạo chuẩn hóa sản phẩm
     *
     * @return mixed
     */
    public function create();

    /**
     * Lưu chuẩn hóa sản phẩm đơn
     *
     * @param array $attributes
     * @return mixed
     */
    public function store($attributes);

    /**
     * Cập nhật chuẩn hóa sản phẩm đơn
     *
     * @param integer $id
     * @param  array $attributes
     * @return mixed
     */
    public function update($id, $attributes);

    /**
     * Lưu chuẩn hóa sản phẩm combo
     *
     * @param  array $attributes
     * @return mixed
     */
    public function storeCombo($attributes);

    /**
     * Cập nhật chuẩn hóa sản phẩm combo
     *
     * @param  int $id
     * @param  array $attributes
     * @return mixed
     */
    public function updateCombo($id, $attributes);
}