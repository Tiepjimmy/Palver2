<?php


namespace App\Http\Controllers;

use App\Exceptions\ProxyNotFoundException;
use App\Services\Proxies\IProxy;
use App\Services\Proxies\ProxyServiceFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * proxy all service
 * @package App\Http\Controllers
 */
class ProxyController extends Controller
{
    /**
     * @var ProxyServiceFactory
     */
    private $proxyServiceFactory;

    /**
     * Constructor.
     * @param ProxyServiceFactory $factory
     */
    function __construct(ProxyServiceFactory $factory)
    {
        $this->proxyServiceFactory = $factory;
    }

    /**
     * @param Request $request
     * @param $uri
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ProxyNotFoundException
     */
    public function get(Request $request, $uri)
    {
        $response = $this->getService($uri)->proxyGet("/{$uri}", $request->input());
        return $this->compareResult($response);
    }

    /**
     * @param Request $request
     * @param $uri
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ProxyNotFoundException
     */
    public function post(Request $request, $uri)
    {
        $response = $this->getService($uri)->proxyPost("/{$uri}", $request->query(), $request->input(), $request->allFiles());
        return $this->compareResult($response);
    }

    /**
     * @param Request $request
     * @param $uri
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ProxyNotFoundException
     */
    public function patch(Request $request, $uri)
    {
        $response = $this->getService($uri)->proxyPatch("/{$uri}", $request->query(), $request->input());
        return $this->compareResult($response);
    }

    /**
     * @param Request $request
     * @param $uri
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ProxyNotFoundException
     */
    public function delete(Request $request, $uri)
    {
        $response = $this->getService($uri)->proxyDelete("/{$uri}", $request->query(), $request->input());
        return $this->compareResult($response);
    }

    /**
     * Lấy instance of service
     * @param $uri
     * @return IProxy
     * @throws ProxyNotFoundException
     * @throws BindingResolutionException
     */
    private function getService($uri){
        $analyticResult = $this->proxyServiceFactory->serviceNameAnalyticFromUri($uri);
        return $this->proxyServiceFactory->getInstanceOfProxy($analyticResult['service_name'], $analyticResult['version']);
    }

    /**
     * @param $proxyResult
     * @return JsonResponse
     */
    private function compareResult($proxyResult){
        return response()->json($proxyResult->getJson(), $proxyResult->getHttpStatus());
    }

    /**
     * @param $param
     * @param $uri
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ProxyNotFoundException
     */
    public function postParam($uri, $param)
    {
        $response = $this->getService($uri)->proxyPost("/{$uri}", [], $param, []);

        return array_merge($response->getJson(), array('status_code' => $response->getHttpStatus()));
    }
}