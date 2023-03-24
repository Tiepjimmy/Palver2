<?php


namespace App\Services\Proxies;


use App\Exceptions\ProxyNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Lấy instance của proxy tương ứng
 * @package App\Services\Proxies
 */
class ProxyServiceFactory
{
    /**
     * Get instance of class
     * @param $serviceName
     * @param $version
     * @return mixed
     * @throws BindingResolutionException|ProxyNotFoundException
     */
    public function getInstanceOfProxy($serviceName, $version){
        $prefix = ucfirst($serviceName).ucfirst($version);
        $targetClass = "App\\Services\\Proxies\\Impls\\{$prefix}Proxy";
        if(class_exists($targetClass)){
            return app()->make($targetClass);
        }
        throw new ProxyNotFoundException();
    }

    /**
     * Từ URI lấy ra serviceName, version
     * Sample uri: /account/v1/xxx/yyy/zzz
     * @param $uri
     * @return array
     * @throws ProxyNotFoundException
     */
    public function serviceNameAnalyticFromUri($uri){
        $pathConfig = explode('/', $uri);
        $serviceName = null;
        $version = null;
        if(isset($pathConfig[0])){
            $serviceName = $pathConfig[0];
        }
        if(isset($pathConfig[1])){
            $version = $pathConfig[1];
        }
        if(empty($serviceName) || empty($version)){
            throw new ProxyNotFoundException('URI invalid sample (/account/v1/xxx/yyy/zzz)');
        }
        return [
            'service_name' => $serviceName,
            'version' => $version,
            'proxy_uri' => $uri
        ];
    }
}