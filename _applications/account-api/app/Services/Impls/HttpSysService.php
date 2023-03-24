<?php


namespace App\Services\Impls;


use App\Services\IHttpSysService;
use Illuminate\Support\Facades\Http;

class HttpSysService implements IHttpSysService
{
    protected $getUrl;
    public function __construct()
    {
        $this->getUrl = config('url_api_system_service.url_api');
    }

    /**
     * getHttp
     * @param $pathUrl
     * @param $param
     * @return array|null
     */
    public function get($pathUrl, $param){
        $apiService = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get($this->getUrl.$pathUrl,$param);

        $json = $apiService->json();

        if(!isset($json['status_code'])){
            return null;
        }
        if(!isset($json['data'])){
            return null;
        }
        return $json['data'];
    }

    /**
     * postHttp
     * @param $pathUrl
     * @param $param
     * @return array|null
     */
    public function post($pathUrl, $param){
        $apiService = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->getUrl.$pathUrl,$param);
        $json = $apiService->json();
        if(!isset($json['status_code'])){
            return null;
        }
        if(!isset($json['data'])){
            return null;
        }
        return $json['data'];
    }

    /**
     * patchHttp
     * @param $pathUrl
     * @param $param
     * @return array|null
     */
    public function patch($pathUrl, $param){

        $apiService = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->patch($this->getUrl.$pathUrl,$param);

        $json = $apiService->json();

        if(!isset($json['status_code'])){
            return null;
        }
        if(!isset($json['data'])){
            return null;
        }
        return $json['data'];
    }

}