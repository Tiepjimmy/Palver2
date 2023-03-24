<?php

namespace App\Providers;

use App\Services\IHttpSysService;
use App\Services\Impls\HttpSysService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        IHttpSysService::class => HttpSysService::class,

    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('is_phone_number', function($attribute, $value) {
            return strlen($value) == 10 && preg_match('/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/', $value);
        });

        \Validator::extend('is_username', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
    }
}
