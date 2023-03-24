<?php

namespace App\Providers;

use App\Helpers\ModuleHelper;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleBaseRegisterProvider
 * @package App\Providers
 * @author HuyDien <huydien.it@gmail.com>
 */
class ModuleBaseRegisterProvider extends ServiceProvider
{
    /**
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function register()
    {
        $moduleAppServiceProvider = ModuleHelper::getAllModuleServiceProvider();
        foreach ($moduleAppServiceProvider as $provider) {
            $this->app->register($provider);
        }
    }

}
