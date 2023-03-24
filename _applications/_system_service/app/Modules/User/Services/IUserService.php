<?php


namespace App\Modules\User\Services;


interface IUserService
{
    /**
     * Tạo mới user
     * @param mixed $attributes
     * @return mixed
     */
    public function store($attributes);

    /**
     * Cập nhật user
     * @param mixed $attributes
     * @return mixed
     */
    public function update($attributes);

}
