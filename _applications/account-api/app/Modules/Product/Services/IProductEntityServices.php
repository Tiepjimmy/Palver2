<?php


namespace App\Modules\Product\Services;

/**
 * ProductEntity Service
 * @package App\Modules\Product\Services
 */
interface IProductEntityServices
{
    /**
     * Tìm kiếm chuẩn hóa sản phẩm biến thể
     * 
     * @param mixed  $request
     * @return array
     */
    public function search($request);

    /**
     * Lưu chuẩn hóa sản phẩm biến thể đơn
     *
     * @param  array $attributes
     * @return void
     */
    public function store($id, $attributes);

    /**
     * Cập nhật chuẩn hóa sản phẩm biến thể đơn
     *
     * @param  mixed $id
     * @param  mixed $attributes
     * @return void
     */
    public function update($id, $attributes);

    /**
     * Lưu chuẩn hóa sẩn phẩm biến thể combo
     *
     * @param  mixed $attributes
     * @return void
     */
    public function storeCombo($id, $attributes);

    /**
     * Cập nhật chuẩn hóa sản phẩm biến thể combo
     *
     * @param  mixed $attributes
     * @return void
     */
    public function updateCombo($id, $attributes);
}