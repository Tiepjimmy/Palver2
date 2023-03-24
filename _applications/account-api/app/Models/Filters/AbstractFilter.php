<?php

namespace App\Models\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AbstractFilter
 * @package App\Models\Filters
 * @author HuyDien <huydien.it@gmail.com>
 */
abstract class AbstractFilter
{
    /**
     * @var
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected $builder;

    /**
     * @var
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected $request;

    /**
     * AbstractFilter constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->_getAllRequest() as $key => $value) {
            if (method_exists($this, $key)) {
                call_user_func_array([$this, $key], array_filter([$value]));
            }
        }
        return $this->builder;
    }

    /**
     * @return array
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function _getAllRequest()
    {
        return $this->request instanceof Request ? $this->request->all() : $this->request;
    }
}
