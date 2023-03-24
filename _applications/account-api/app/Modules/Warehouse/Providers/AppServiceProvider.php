<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\Example\Providers
 */

namespace App\Modules\Warehouse\Providers;

use App\Modules\Warehouse\Repositories\Contracts\WarehouseInterface;
use App\Modules\Warehouse\Repositories\Contracts\WarehouseStoreInterface;
use App\Modules\Warehouse\Repositories\Contracts\WarehouseTypeInterface;
use App\Modules\Warehouse\Repositories\Eloquent\WarehouseRepository;
use App\Modules\Warehouse\Repositories\Eloquent\WarehouseStoreRepository;
use App\Modules\Warehouse\Repositories\Eloquent\WarehouseTypeRepository;
use App\Modules\Warehouse\Services\Impls\WarehouseServices;
use App\Modules\Warehouse\Services\IWarehouseService;
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
        IWarehouseService::class => WarehouseServices::class,
        WarehouseInterface::class => WarehouseRepository::class,
        WarehouseStoreInterface::class => WarehouseStoreRepository::class,
        WarehouseTypeInterface::class => WarehouseTypeRepository::class
    ];
}
