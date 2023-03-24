<?php


namespace App\Modules\Authentication\Services;

use \Common\Auth\Contracts\ISecretProvider as Base;

/**
 * Interface ISecretProvider
 * @package App\Modules\Authentication\Services
 */
interface ISecretProvider extends Base
{
    /**
     * @return mixed
     */
    public function getPrivateKey();

}