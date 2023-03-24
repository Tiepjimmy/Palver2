<?php


namespace App\Modules\Product\Services;

/**
 * RetailProduct Service
 * @package App\Modules\Product\Services
 */
interface IRetailProductServices
{
    /**
     * Tìm kiếm chuẩn hóa sản phẩm chi nhánh
     *
     * @param  array $request
     * @return array
     */
    public function search($request);

    /**
     * Lấy chuẩn hóa sản phẩm chi nhánh theo id
     *
     * @param  int $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Lưu chuẩn hóa sản phẩm chi nhánh đơn
     *
     * @param  array $attributes
     * @return mixed
     */
    public function store($attributes);

    /**
     * Lưu chuẩn hóa sản phẩm chi nhánh combo
     *
     * @param  array $attributes
     * @return mixed
     */
    public function storeCombo($attributes);

    /**
     * Cập nhật chuẩn hóa sản phẩm chi nhánh đơn
     *
     * @param  int $id
     * @param  array $attributes
     * @return mixed
     */
    public function update($id, $attributes);

    /**
     * Cập nhật chuẩn hóa sản phẩm chi nhánh combo
     *
     * @param  int $id
     * @param  array $attributes
     * @return mixed
     */
    public function updateCombo($id, $attributes);
}