<?php

namespace App\Modules\Store\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Store\Services\IJobTitleService;
use App\Modules\Store\Repositories\Contracts\StoreInterface;
use App\Modules\Store\Repositories\Contracts\JobTitleInterface;
use App\Modules\Store\Services\Impls\JobTitleServiceImplement;
use App\Modules\Store\Repositories\Eloquent\StoreRepository;
use App\Modules\Store\Repositories\Eloquent\JobTitleRepository;

/**
 * Class AppServiceProvider
 * @package App\Modules\Store\Providers
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
        IJobTitleService::class => JobTitleServiceImplement::class,
        StoreInterface::class => StoreRepository::class,
        JobTitleInterface::class => JobTitleRepository::class
    ];
}
