<?php

namespace App\Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\User\Services\IUserService;
use App\Modules\User\Services\IAssignService;
use App\Modules\User\Services\Impls\UserServiceImplement;
use App\Modules\User\Services\Impls\AssignServiceImplement;
use App\Modules\User\Repositories\Contracts\AssignInterface;
use App\Modules\User\Repositories\Contracts\AssignPermissionGroupInterface;
use App\Modules\User\Repositories\Contracts\PasswordHistoryInterface;
use App\Modules\User\Repositories\Contracts\PermissionGroupInterface;
use App\Modules\User\Repositories\Contracts\PermissionPermissionGroupInterface;
use App\Modules\User\Repositories\Contracts\StorePermissionGroupInterface;
use App\Modules\User\Repositories\Contracts\UserInterface;
use App\Modules\User\Repositories\Contracts\UserTokenInterface;
use App\Modules\User\Repositories\Eloquent\AssignRepository;
use App\Modules\User\Repositories\Eloquent\AssignPermissionGroupRepository;
use App\Modules\User\Repositories\Eloquent\PasswordHistoryRepository;
use App\Modules\User\Repositories\Eloquent\PermissionGroupRepository;
use App\Modules\User\Repositories\Eloquent\PermissionPermissionGroupRepository;
use App\Modules\User\Repositories\Eloquent\StorePermissionGroupRepository;
use App\Modules\User\Repositories\Eloquent\UserRepository;
use App\Modules\User\Repositories\Eloquent\UserTokenRepository;

/**
 * Class AppServiceProvider
 * @package App\Modules\User\Providers
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
        IUserService::class => UserServiceImplement::class,
        IAssignService::class => AssignServiceImplement::class,
        AssignInterface::class => AssignRepository::class,
        AssignPermissionGroupInterface::class => AssignPermissionGroupRepository::class,
        PasswordHistoryInterface::class => PasswordHistoryRepository::class,
        PermissionGroupInterface::class => PermissionGroupRepository::class,
        PermissionPermissionGroupInterface::class => PermissionPermissionGroupRepository::class,
        StorePermissionGroupInterface::class => StorePermissionGroupRepository::class,
        UserInterface::class => UserRepository::class,
        UserTokenInterface::class => UserTokenRepository::class
    ];
}
