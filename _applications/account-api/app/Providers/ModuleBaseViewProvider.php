<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleBaseViewProvider
 * @package App\Providers
 * @author HuyDien <huydien.it@gmail.com>
 */
class ModuleBaseViewProvider extends ServiceProvider
{
    /**
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function register()
    {
        //
    }

    /**
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function boot()
    {
        $this->mapViewModules();
    }

    /**
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function mapViewModules()
    {
        $baseModulePath = app_path('Modules');
        $moduleNames = array_map('basename', File::directories($baseModulePath));
        foreach ($moduleNames as $moduleName) {
            $viewPath = app_path("Modules/$moduleName/Views");
            $this->loadViewsFrom($viewPath, $moduleName);
        }
    }

}
