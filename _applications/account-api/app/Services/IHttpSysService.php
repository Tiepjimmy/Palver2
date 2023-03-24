<?php


namespace App\Services;


interface IHttpSysService
{
    /**
     * get http service
     * @param  mixed $pathUrl
     * @param mixed $param
     * @return mixed
     */
    public function get($pathUrl,$param);

    /**
     * post http service
     * @param  mixed $pathUrl
     * @param mixed $param
     * @return mixed
     */
    public function post($pathUrl, $param);

    /**
     * patch http service
     * @param mixed $pathUrl
     * @param mixed $param
     * @return mixed
     */
    public function patch($pathUrl,$param);

}