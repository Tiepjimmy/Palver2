<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\Example\Providers
 */

namespace App\Modules\ProductCatalogs\Providers;

use App\Modules\ProductCatalogs\Repositories\Contracts\ProductCatalogsInterface;
use App\Modules\ProductCatalogs\Repositories\Contracts\StoreProductCatalogInterface;
use App\Modules\ProductCatalogs\Repositories\Eloquent\ProductCatalogsRepository;
use App\Modules\ProductCatalogs\Repositories\Eloquent\StoreProductCatalogRepository;
use App\Modules\ProductCatalogs\Services\Impls\ProductCatalogsServices;
use App\Modules\ProductCatalogs\Services\IProductCatalogsService;
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
        IProductCatalogsService::class => ProductCatalogsServices::class,
        ProductCatalogsInterface::class => ProductCatalogsRepository::class,
        StoreProductCatalogInterface::class => StoreProductCatalogRepository::class
    ];
}
