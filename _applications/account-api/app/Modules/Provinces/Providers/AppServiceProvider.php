<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\Example\Providers
 */

namespace App\Modules\Provinces\Providers;

use App\Modules\Provinces\Repositories\Contracts\ProvincesInterface;
use App\Modules\Provinces\Repositories\Eloquent\ProvincesRepository;
use App\Modules\Provinces\Services\Impls\ProvincesServices;
use App\Modules\Provinces\Services\IProvincesService;
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
        IProvincesService::class => ProvincesServices::class,
        ProvincesInterface::class => ProvincesRepository::class
    ];
}
