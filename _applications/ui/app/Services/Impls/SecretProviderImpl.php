<?php


namespace App\Services\Impls;

use App\Services\Clients\PalServiceClient;
use Common\Auth\Contracts\ISecretProvider;
use Nette\NotImplementedException;

/**
 * Class SecretProviderImpl
 * @package App\Services\Impls
 */
class SecretProviderImpl implements ISecretProvider
{

    protected $palServiceClient;

    /**
     * SecretProviderImpl constructor.
     * @param PalServiceClient $palServiceClient
     */
    public function __construct(PalServiceClient $palServiceClient)
    {
        $this->palServiceClient = $palServiceClient;

    }

    /**
     * @return mixed|string
     */
    public function getUserInfoApi()
    {
        return $this->palServiceClient->getGatewayUrl().config('pal_services.user_info_uri');
    }

    /**
     * @return mixed|void
     */
    public function getPublicKey()
    {
        throw new NotImplementedException();
    }
}