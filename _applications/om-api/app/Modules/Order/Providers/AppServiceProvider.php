<?php

namespace App\Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Order\Repositories\Contracts\IOrderCancelReasonRepository;
use App\Modules\Order\Repositories\Contracts\IOrderPaymentRepository;
use App\Modules\Order\Repositories\Eloquent\OrderCancelReasonRepository;
use App\Modules\Order\Repositories\Eloquent\OrderPaymentRepository;

/**
 * Class AppServiceProvider
 * @package App\Modules\Order\Providers
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
        IOrderCancelReasonRepository::class => OrderCancelReasonRepository::class,
        IOrderPaymentRepository::class => OrderPaymentRepository::class,
    ];
}
