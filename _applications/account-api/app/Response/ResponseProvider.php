<?php

namespace App\Response;

use Illuminate\Support\ServiceProvider;

/**
 * Class ResponseProvider
 * @package App\Response
 * @author HuyDien <huydien.it@gmail.com>
 */
class ResponseProvider extends ServiceProvider
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function register()
    {
        app()->make(Response::class);
    }
}
