<?php

namespace App\Response\Json;

use App\Response\Contracts\ResponseAbstract;
use App\Response\Contracts\ResponseInterface;
use Illuminate\Routing\ResponseFactory;

/**
 * Class Message
 * @package App\Response\Json
 * @author HuyDien <huydien.it@gmail.com>
 */
class Message extends ResponseAbstract implements ResponseInterface
{
    /**
     * @param ResponseFactory $factory
     * @return mixed|void
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function run(ResponseFactory $factory)
    {
        $factory->macro('responseMessage', function ($messages = 'Success', $appendData = array(), $statusCode = 200, $success = true) use ($factory) {
            $response = array(
                'status_code' => $statusCode,
                'success' => $success,
                'message' => $messages,
                'data' => $appendData
            );

            return $factory->make($response, $statusCode);
        });
    }
}
