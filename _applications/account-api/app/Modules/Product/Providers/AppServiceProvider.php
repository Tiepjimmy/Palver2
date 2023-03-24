<?php

namespace App\Modules\Product\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Product\Services\IAttributeService;
use App\Modules\Product\Services\IAttributeGroupService;
use App\Modules\Product\Repositories\Contracts\AttributeFloatInterface;
use App\Modules\Product\Repositories\Contracts\AttributeGroupInterface;
use App\Modules\Product\Repositories\Contracts\AttributeIntInterface;
use App\Modules\Product\Repositories\Contracts\AttributeVarcharInterface;
use App\Modules\Product\Repositories\Contracts\ProductAttributeInterface;
use App\Modules\Product\Repositories\Contracts\ProductCatalogAttributeGroupInterface;
use App\Modules\Product\Repositories\Contracts\ProductCatalogInterface;
use App\Modules\Product\Services\Impls\AttributeImplement;
use App\Modules\Product\Services\Impls\AttributeGroupImplement;
use App\Modules\Product\Repositories\Eloquent\AttributeFloatRepository;
use App\Modules\Product\Repositories\Eloquent\AttributeGroupRepository;
use App\Modules\Product\Repositories\Eloquent\AttributeIntRepository;
use App\Modules\Product\Repositories\Eloquent\AttributeVarcharRepository;
use App\Modules\Product\Repositories\Eloquent\ProductAttributeRepository;
use App\Modules\Product\Repositories\Eloquent\ProductCatalogAttributeGroupRepository;
use App\Modules\Product\Repositories\Eloquent\ProductCatalogRepository;

/**
 * Class AppServiceProvider
 * @package App\Modules\Product\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public $bindings = [
        \App\Modules\Product\Repositories\Contracts\ProductCatalogInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductCatalogRepository::class,
        \App\Modules\Product\Repositories\Contracts\VolumeUnitInterface::class => \App\Modules\Product\Repositories\Eloquent\VolumeUnitRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductGalleryInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductGalleryRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductEntityInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductEntityRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductEntityPriceInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductEntityPriceRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductEntityAttributeFloatInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductEntityAttributeFloatRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductEntityAttributeIntInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductEntityAttributeIntRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductEntityAttributeVarcharInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductEntityAttributeVarcharRepository::class,
        \App\Modules\Product\Repositories\Contracts\ProductProviderInterface::class => \App\Modules\Product\Repositories\Eloquent\ProductProviderRepository::class,
        \App\Modules\Product\Repositories\Contracts\ComboInterface::class => \App\Modules\Product\Repositories\Eloquent\ComboRepository::class,
        \App\Modules\Product\Repositories\Contracts\RetailProductInterface::class => \App\Modules\Product\Repositories\Eloquent\RetailProductRepository::class,
        \App\Modules\Product\Repositories\Contracts\RetailProductEntityInterface::class => \App\Modules\Product\Repositories\Eloquent\RetailProductEntityRepository::class,
        \App\Modules\Product\Repositories\Contracts\RetailProductEntityPriceInterface::class => \App\Modules\Product\Repositories\Eloquent\RetailProductEntityPriceRepository::class,
        \App\Modules\Product\Repositories\Contracts\RetailProductGalleryInterface::class => \App\Modules\Product\Repositories\Eloquent\RetailProductGalleryRepository::class,
        \App\Modules\Product\Repositories\Contracts\RetailComboInterface::class => \App\Modules\Product\Repositories\Eloquent\RetailComboRepository::class,
        \App\Modules\Product\Repositories\Contracts\StoreProductCatalogInterface::class => \App\Modules\Product\Repositories\Eloquent\StoreProductCatalogRepository::class,
        \App\Modules\Product\Services\IProductEntityServices::class => \App\Modules\Product\Services\Impls\ProductEntityServices::class,
        \App\Modules\Product\Services\IProductServices::class => \App\Modules\Product\Services\Impls\ProductServices::class,
        \App\Modules\Product\Services\IRetailProductEntityServices::class => \App\Modules\Product\Services\Impls\RetailProductEntityServices::class,
        \App\Modules\Product\Services\IRetailProductServices::class => \App\Modules\Product\Services\Impls\RetailProductServices::class,
        IAttributeService::class => AttributeImplement::class,
        IAttributeGroupService::class => AttributeGroupImplement::class,
        AttributeFloatInterface::class => AttributeFloatRepository::class,
        AttributeGroupInterface::class => AttributeGroupRepository::class,
        AttributeIntInterface::class => AttributeIntRepository::class,
        AttributeVarcharInterface::class => AttributeVarcharRepository::class,
        ProductAttributeInterface::class => ProductAttributeRepository::class,
        ProductCatalogAttributeGroupInterface::class => ProductCatalogAttributeGroupRepository::class,
        ProductCatalogInterface::class => ProductCatalogRepository::class
    ];
}
