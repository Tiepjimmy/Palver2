<?php

namespace App\Modules\Provider\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Provider\Services\IProviderService;
use App\Modules\Provider\Repositories\Contracts\ProductProviderInterface;
use App\Modules\Provider\Repositories\Contracts\ProviderGroupInterface;
use App\Modules\Provider\Repositories\Contracts\ProviderInterface;
use App\Modules\Provider\Repositories\Contracts\ProviderProviderGroupInterface;
use App\Modules\Provider\Repositories\Contracts\StoreProviderInterface;
use App\Modules\Provider\Services\Impls\ProviderServiceImplement;
use App\Modules\Provider\Repositories\Eloquent\ProductProviderRepository;
use App\Modules\Provider\Repositories\Eloquent\ProviderGroupRepository;
use App\Modules\Provider\Repositories\Eloquent\ProviderRepository;
use App\Modules\Provider\Repositories\Eloquent\ProviderProviderGroupRepository;
use App\Modules\Provider\Repositories\Eloquent\StoreProviderRepository;

/**
 * Class AppServiceProvider
 * @package App\Modules\Provider\Providers
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
        IProviderService::class => ProviderServiceImplement::class,
        ProductProviderInterface::class => ProductProviderRepository::class,
        ProviderGroupInterface::class => ProviderGroupRepository::class,
        ProviderInterface::class => ProviderRepository::class,
        ProviderProviderGroupInterface::class => ProviderProviderGroupRepository::class,
        StoreProviderInterface::class => StoreProviderRepository::class
    ];
}
