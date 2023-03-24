<?php


namespace App\Models\DTO;

/**
 * Class ProxyResult
 * @package App\Models\DTO
 */
class ProxyResult
{
    private $httpStatus;
    private $json;

    /**
     * @return mixed
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * @param mixed $httpStatus
     */
    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param mixed $json
     */
    public function setJson($json)
    {
        $this->json = $json;
    }

    /**
     * ProxyResult constructor.
     * @param $httpStatus
     * @param $json
     */
    public function __construct($httpStatus, $json)
    {
        $this->httpStatus = $httpStatus;
        $this->json = $json;
    }
}