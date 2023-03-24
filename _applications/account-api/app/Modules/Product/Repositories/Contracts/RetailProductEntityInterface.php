<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Contracts;

use Common\Repositories\Contracts\AbstractEloquentInterface;

/**
 * Interface RetailProductEntityInterface
 * @package App\Modules\Product\Repositories\Contracts
 * @author HuyDien <huydien.it@gmail.com>
 */
interface RetailProductEntityInterface extends AbstractEloquentInterface
{
    /**
     * @param array $conditions
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function deleteMore($conditions = array());
}