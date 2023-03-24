<?php


namespace App\Modules\Wards\Services;

/**
 * Wards Service
 * @package App\Modules\Wards\Services
 */
interface IWardsService
{
    /**
     * Thực hiện việc tìm kiếm phường xã
     * @param mixed $attributes
     * @return mixed
     */
    public function search($attributes);

}