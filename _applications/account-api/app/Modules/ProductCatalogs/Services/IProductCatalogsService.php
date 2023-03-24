<?php


namespace App\Modules\ProductCatalogs\Services;

/**
 * Product Catalogs Service
 * @package App\Modules\ProductCatalogs\Services
 */
interface IProductCatalogsService
{
    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';

    /**
     * Thực hiện việc tìm kiếm Danh mục sản phẩm
     * @param mixed $attributes
     * @return array
     */
    public function search($attributes);

    /**
     * Thực hiện việc lấy các thông tin liên quan đến Danh mục sản phẩm
     * @return array
     */
    public function create();

    /**
     * Thêm mới Danh mục sản phẩm
     * @param mixed $attributes
     * @return array
     */
    public function store($attributes);

    /**
     * Lấy thông tin chi tiết
     * @param mixed $id
     * @return array
     */
    public function get($id);

    /**
     * cập nhật lại Danh mục sản phẩm
     * @param mixed $id
     * @param mixed $attributes
     * @return array
     */
    public function update($id,$attributes);

}