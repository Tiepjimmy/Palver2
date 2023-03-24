<?php

namespace App\Modules\Master\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Master\Repositories\Contracts\SubSystemInterface;
use App\Modules\Master\Repositories\Contracts\AttributeTypeInterface;
use App\Modules\Master\Repositories\Eloquent\SubSystemRepository;
use App\Modules\Master\Repositories\Eloquent\AttributeTypeRepository;

/**
 * Class AppServiceProvider
 * @package App\Modules\Master\Providers
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
        SubSystemInterface::class => SubSystemRepository::class,
        AttributeTypeInterface::class => AttributeTypeRepository::class
    ];
}
