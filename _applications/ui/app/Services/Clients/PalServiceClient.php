<?php


namespace App\Services\Clients;


use App\Models\DTO\ProxyResult;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PalServiceClient
{
    /**
     * @param $url
     * @return ProxyResult
     * @throws BindingResolutionException
     */
    protected function get($url)
    {
        $response = $this->getPendingRequest()->get($this->getGatewayUrl() . $url);
        return $this->analyticResult($response);
    }

    /**
     * @param $url
     * @param array $body
     * @return ProxyResult
     * @throws BindingResolutionException
     */
    protected function post($url, array $body)
    {
        $response = $this->getPendingRequest()->post($this->getGatewayUrl() . $url, $body);
        return $this->analyticResult($response);
    }

    /**
     * @param $url
     * @param array $body
     * @return ProxyResult
     * @throws BindingResolutionException
     */
    protected function patch($url, array $body)
    {
        $response = $this->getPendingRequest()->patch($this->getGatewayUrl() . $url, $body);
        return $this->analyticResult($response);
    }

    /**
     * @param $url
     * @param array $body
     * @return ProxyResult
     * @throws BindingResolutionException
     */
    protected function delete($url, array $body)
    {
        $response = $this->getPendingRequest()->delete($this->getGatewayUrl() . $url, $body);
        return $this->analyticResult($response);
    }

    /**
     * Get Request
     * @return PendingRequest
     */
    protected function getPendingRequest()
    {
        if(Auth::guest()){
            return Http::withHeaders(['Accept' => 'application/json']);
        }else{
            return Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . Auth::user()->jwt,
            ]);
        }
    }

    /**
     * @param Response $response
     * @return ProxyResult
     * @throws BindingResolutionException
     */
    protected function analyticResult(Response $response){
        return app()->make(ProxyResult::class, ['httpStatus' => $response->status(), 'json' => $response->json()]);
    }

    /**
     * inject domain to request
     * @return mixed
     */
    public function getGatewayUrl(){
        $domainAnalytic = explode('.', request()->getHost());
        $subdomain = $domainAnalytic[0];
        $gatewayConfig = config('pal_services')['gateway'];
        return str_replace('__domain__', $subdomain, $gatewayConfig);
    }

}
