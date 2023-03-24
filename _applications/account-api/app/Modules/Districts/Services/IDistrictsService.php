<?php


namespace App\Modules\Districts\Services;

/**
 * District Service
 * @package App\Modules\Districts\Services
 */
interface IDistrictsService
{
    /**
     * Thực hiện việc tìm kiếm quận/huyện
     * @param mixed  $attributes
     * @return array
     */
    public function search($attributes);
}