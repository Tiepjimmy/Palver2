<?php

namespace App\Modules\Stores\Repositories\Contracts;


use Common\Repositories\Contracts\AbstractEloquentInterface;

/**
 * Interface StoresInterface
 * @package App\Modules\Stores\Repositories\Contracts
 */
interface StoresInterface extends AbstractEloquentInterface
{
    /**
     * Validation rules
     * @return mixed
     */
    public function rules();

}
