<?php


namespace App\Modules\Product\Services;

/**
 * RetailProductEntity Service
 * @package App\Modules\Product\Services
 */
interface IRetailProductEntityServices
{
    /**
     * Tìm kiếm sản phẩm chi nhánh biến thể
     *
     * @param  array $request
     * @return array
     */
    public function search($request);

    /**
     * Lấy sản phẩm chi nhánh biến thể theo id
     *
     * @param  int $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Lưu sản phẩm chi nhánh biến thể đơn
     *
     * @param  int $id
     * @param  array $attributes
     * @return void
     */
    public function store($id, $attributes);

    /**
     * Lưu sản phẩm chi nhánh biến thể combo
     *
     * @param integer $id
     * @param  array $attributes
     * @return void
     */
    public function storeCombo($id, $attributes);

    /**
     * Cập nhật sản phẩm chi nhánh biến thể đơn
     *
     * @param  int $id
     * @param  array $attributes
     * @return void
     */
    public function update($id, $attributes);

    /**
     * Cập nhật sản phẩm chi nhánh biến thể combo
     *
     * @param  int $id
     * @param  array $attributes
     * @return void
     */
    public function updateCombo($id, $attributes);
}