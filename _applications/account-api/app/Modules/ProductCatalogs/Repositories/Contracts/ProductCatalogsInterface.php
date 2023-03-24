<?php

namespace App\Modules\ProductCatalogs\Repositories\Contracts;


use Common\Repositories\Contracts\AbstractEloquentInterface;

/**
 * Interface ProductCatalogsInterface
 * @package App\Modules\ProductCatalogs\Repositories\Contracts
 */
interface ProductCatalogsInterface extends AbstractEloquentInterface
{
    /**
     * Validation rules
     * @return  mixed
     */
    public function rules();

}
