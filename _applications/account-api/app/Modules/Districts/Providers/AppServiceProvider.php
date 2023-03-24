<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\Example\Providers
 */

namespace App\Modules\Districts\Providers;

use App\Modules\Districts\Repositories\Contracts\DistrictsInterface;
use App\Modules\Districts\Repositories\Eloquent\DistrictsRepository;
use App\Modules\Districts\Services\IDistrictsService;
use App\Modules\Districts\Services\Impls\DistrictsServices;
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
        IDistrictsService::class => DistrictsServices::class,
        DistrictsInterface::class => DistrictsRepository::class
    ];
}
