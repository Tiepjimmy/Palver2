<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\Example\Providers
 */

namespace App\Modules\Stores\Providers;

use App\Modules\Stores\Repositories\Contracts\StoresInterface;
use App\Modules\Stores\Repositories\Eloquent\StoresRepository;
use App\Modules\Stores\Services\Impls\StoresServices;
use App\Modules\Stores\Services\IStoresService;
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
        IStoresService::class => StoresServices::class,
        StoresInterface::class => StoresRepository::class
    ];
}
