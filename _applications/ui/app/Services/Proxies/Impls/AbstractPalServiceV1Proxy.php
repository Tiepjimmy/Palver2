<?php


namespace App\Services\Proxies\Impls;


use App\Services\Clients\PalServiceClient;
use App\Services\Proxies\IProxy;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class AbstractPalServiceV1Proxy extends PalServiceClient implements IProxy
{
    /** @inheritDoc
     * @throws BindingResolutionException
     */
    public function proxyGet($url, $parameters){
        return $this->get($url.'?'.http_build_query($parameters));
    }

    /** @inheritDoc
     * @throws BindingResolutionException
     */
    public function proxyPost($url, $query = null, $body = null, $files = null)
    {
        return $this->post($url.'?'.http_build_query($query), $body);
    }

    /** @inheritDoc
     * @throws BindingResolutionException
     */
    public function proxyPatch($url, $query = null, $body = null)
    {
        return $this->patch($url.'?'.http_build_query($query), $body);
    }

    /** @inheritDoc
     * @throws BindingResolutionException
     */
    public function proxyDelete($url, $query = null, $body = null)
    {
        return $this->delete($url.'?'.http_build_query($query), $body);
    }
}