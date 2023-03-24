<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleBaseRouteProvider
 * @package App\Providers
 * @author HuyDien <huydien.it@gmail.com>
 */
class ModuleBaseRouteProvider extends ServiceProvider
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
        $this->mapRouteModule();
    }

    /**
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function mapRouteModule()
    {
        $baseModulePath = app_path('Modules');
        $moduleNames = array_map('basename', File::directories($baseModulePath));
        foreach ($moduleNames as $moduleName) {
            $modulePath = $baseModulePath . '/' . $moduleName;
            $namespace = "App\\Modules\\$moduleName\\Controllers";
            $this->mapWebRoutes($modulePath, $namespace);
            $this->mapAdminRoutes($modulePath, $namespace);
            $this->mapApiRoutes($modulePath, $namespace);
        }
    }

    /**
     * @param $modulePath
     * @param $namespace
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function mapAdminRoutes($modulePath, $namespace)
    {
        $routeFile = $modulePath . '/Routes/admin.php';
        Route::middleware('web')
            ->prefix('admin')
            ->namespace($namespace . '\\Admin')
            ->group($routeFile);
    }

    /**
     * @param $modulePath
     * @param $namespace
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function mapWebRoutes($modulePath, $namespace)
    {
        $routeFile = $modulePath . '/Routes/web.php';
        Route::middleware('web')
            ->namespace($namespace . '\\Web')
            ->group($routeFile);
    }

    /**
     * @param $modulePath
     * @param $namespace
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function mapApiRoutes($modulePath, $namespace)
    {
        $routeFile = $modulePath . '/Routes/api.php';
        Route::prefix('api')
            ->middleware('api')
            ->namespace($namespace . '\\Api')
            ->group($routeFile);
    }
}
