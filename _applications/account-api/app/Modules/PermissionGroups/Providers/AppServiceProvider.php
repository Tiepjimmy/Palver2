<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\PermissionGroups\Providers
 * @author Electric <huydien.it@gmail.com>
 */

namespace App\Modules\PermissionGroups\Providers;

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
        \App\Modules\PermissionGroups\Repositories\Contracts\PermissionPermissionGroupInterface::class => \App\Modules\PermissionGroups\Repositories\Eloquent\PermissionPermissionGroupRepository::class,
        \App\Modules\PermissionGroups\Repositories\Contracts\StorePermissionGroupInterface::class => \App\Modules\PermissionGroups\Repositories\Eloquent\StorePermissionGroupRepository::class,
        \App\Modules\PermissionGroups\Repositories\Contracts\PermissionGroupInterface::class => \App\Modules\PermissionGroups\Repositories\Eloquent\PermissionGroupRepository::class,
        \App\Modules\PermissionGroups\Repositories\Contracts\SubSystemInterface::class => \App\Modules\PermissionGroups\Repositories\Eloquent\SubSystemRepository::class,
        \App\Modules\PermissionGroups\Repositories\Contracts\StoreInterface::class => \App\Modules\PermissionGroups\Repositories\Eloquent\StoreRepository::class,
        \App\Modules\PermissionGroups\Services\IPermissionGroupsServices::class => \App\Modules\PermissionGroups\Services\Impls\PermissionGroupsServices::class
    ];
}
