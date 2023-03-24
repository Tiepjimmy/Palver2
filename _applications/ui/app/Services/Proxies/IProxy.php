<?php


namespace App\Services\Proxies;


use App\Models\DTO\ProxyResult;

/**
 * Interface cho việc passing proxy
 * @package App\Services\Proxies
 */
interface IProxy
{
    /**
     * Passing all GET request
     * @param $url
     * @param $parameters
     * @return ProxyResult
     */
    public function proxyGet($url, $parameters);

    /**
     * Passing all POST request
     * @param $url
     * @param null $query
     * @param null $body
     * @param $files
     * @return ProxyResult
     */
    public function proxyPost($url, $query = null, $body = null, $files = null);

    /**
     * Passing all PATCH Request
     * @param $url
     * @param null $query
     * @param null $body
     * @return ProxyResult
     */
    public function proxyPatch($url, $query = null, $body = null);

    /**
     * Passing all DELETED Request
     * @param $url
     * @param null $query
     * @param null $body
     * @return ProxyResult
     */
    public function proxyDelete($url, $query = null, $body = null);

}
