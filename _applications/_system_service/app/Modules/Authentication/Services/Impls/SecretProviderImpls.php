<?php


namespace App\Modules\Authentication\Services\Impls;


use App\Modules\Authentication\Models\TenancyContract;
use Common\Auth\Contracts\ISecretProvider;

/**
 * Class SecretProviderImpls
 * @package App\Modules\Authentication\Services\Impls
 */
class SecretProviderImpls implements ISecretProvider
{
    private $tenancyContract;

    /**
     * SecretProviderImpls constructor.
     * @param TenancyContract $tenancyContract
     */
    public function __construct(TenancyContract $tenancyContract)
    {
        $this->tenancyContract = $tenancyContract;
    }

    /**
     * @return mixed|string
     */
    public function getUserInfoApi()
    {
       return $this->tenancyContract->user_info_endpoint;
    }

    /**
     * @return mixed|string
     */
    public function getPublicKey()
    {
        return $this->tenancyContract->public_key;
    }
}
