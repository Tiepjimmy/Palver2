<?php


namespace App\Modules\Authentication\Services\Impls;

use App\Modules\Authentication\Services\ISecretProvider;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Nette\NotImplementedException;

/**
 * Class SecretService
 * @package App\Modules\Authentication\Services\Impls
 */
class SecretService implements ISecretProvider
{
    /**
     * @return mixed|void
     */
    public function getUserInfoApi()
    {
        throw new NotImplementedException();
    }

    /**
     * @return Repository|Application|mixed
     */
    public function getPublicKey()
    {
        return config('sso.public_key');
    }

    /**
     * @return Repository|Application|mixed
     */
    public function getPrivateKey()
    {
        return config('sso.private_key');
    }
}