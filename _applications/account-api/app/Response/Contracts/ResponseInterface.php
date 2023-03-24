<?php

namespace App\Response\Contracts;

use Illuminate\Routing\ResponseFactory;

/**
 * Interface ResponseInterface
 * @package App\Response\Contracts
 * @author HuyDien <huydien.it@gmail.com>
 */
interface ResponseInterface
{
    /**
     * @param ResponseFactory $factory
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function run(ResponseFactory $factory);
}
