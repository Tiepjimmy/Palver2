<?php


namespace App\Modules\Provinces\Services;

/**
 * Provinces Service
 * @package App\Modules\Provinces\Services
 */
interface IProvincesService
{
    /**
     * Thực hiện việc tìm kiếm thành phố/tỉnh
     * @param mixed $attributes
     * @return mixed
     */
    public function search($attributes);
}