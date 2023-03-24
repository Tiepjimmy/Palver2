<?php

namespace App\Modules\Warehouse\Repositories\Contracts;


use Common\Repositories\Contracts\AbstractEloquentInterface;

/**
 * Interface WarehouseInterface
 * @package App\Modules\Warehouse\Repositories\Contracts
 * @author HuyDien <huydien.it@gmail.com>
 */
interface WarehouseInterface extends AbstractEloquentInterface
{
    /**
     * Validation rules
     * @return mixed
     */
    public function rules();

}
