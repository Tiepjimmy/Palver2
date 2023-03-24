<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\Example\Providers
 */

namespace App\Modules\Wards\Providers;

use App\Modules\Wards\Repositories\Contracts\WardsInterface;
use App\Modules\Wards\Repositories\Eloquent\WardsRepository;
use App\Modules\Wards\Services\Impls\WardsServices;
use App\Modules\Wards\Services\IWardsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public $bindings = [
        IWardsService::class => WardsServices::class,
        WardsInterface::class => WardsRepository::class
    ];
}
