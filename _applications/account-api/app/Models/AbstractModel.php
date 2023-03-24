<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractModel
 * @package App\Models\Entities
 * @author HuyDien <huydien.it@gmail.com>
 */
abstract class AbstractModel extends Model
{
    /**
     *
     */
    const CREATED_AT = 'created_at';
    /**
     *
     */
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    /**
     * @param $attributeName
     * @return null
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function get($attributeName)
    {
        return isset($this->attributes[$attributeName]) ? $this->attributes[$attributeName] : null;
    }
}
