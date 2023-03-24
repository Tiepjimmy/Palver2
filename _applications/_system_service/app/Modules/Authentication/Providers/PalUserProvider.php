<?php

namespace App\Modules\Authentication\Providers;

use App\Modules\Authentication\Models\User;
use App\Modules\Authentication\Repositories\Contracts\TenancyContractRepositoryInterface;
use App\Modules\Authentication\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Authentication\Services\Impls\SecretProviderImpls;
use Common\Auth\AbstractPalUserProvider;
use Common\Auth\Contracts\ISecretProvider;
use Common\Auth\Models\SessionUser;
use Common\Exceptions\PalException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Redis;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class PalUserProvider
 * @package App\Modules\Authentication\Providers
 */
class PalUserProvider extends AbstractPalUserProvider
{
    CONST USER_INFO_ENDPOINT_KEY =  'user_info_endpoint';
    CONST TENANCY_ID_KEY =  'tenancy_id';

    /**
     * @param mixed $identifier
     * @return Authenticatable|mixed|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function retrieveById($identifier)
    {
        $tenancyId = session()->get(self::TENANCY_ID_KEY);
        if(empty($tenancyId)){
            return null;
        }
        $tenancyRepository = app()->get(TenancyContractRepositoryInterface::class);
        $tenancyContract = $tenancyRepository->getOne(['id' => $tenancyId]);
        if(empty($tenancyContract)){
            return null;
        }
        app()->bind(ISecretProvider::class, function() use($tenancyContract){
            return app()->make(SecretProviderImpls::class, [ 'tenancyContract' => $tenancyContract]);
        });
        return parent::retrieveById($identifier);
    }

    /**
     * @param array $credentials
     * @return Authenticatable|mixed|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws PalException
     */
    public function retrieveByCredentials(array $credentials)
    {
        $userRepository = app()->get(UserRepositoryInterface::class);
        $user = $userRepository->getUserByUsername($credentials['username']);
        if(is_null($user)) {
            return null;
        }
        $tenancyContract = $user->tenancyContract;
        app()->bind(ISecretProvider::class, function() use($tenancyContract){
            return app()->make(SecretProviderImpls::class, ['tenancyContract' => $tenancyContract]);
        });

        $loginResult = $this->authAppend($user, $credentials['password'], $credentials['remember']);
        $info = $this->decodeJwt($loginResult['data']['jwt']);
        if(is_null($info)){
            return null;
        }
        $info = json_decode(json_encode($info), true);
        $user = app()->get(SessionUser::class);
        $user->fill($info);
        $user->jwt = $loginResult['data']['jwt'];
        session()->put(self::USER_INFO_ENDPOINT_KEY, $tenancyContract->user_info_endpoint);
        session()->put(self::TENANCY_ID_KEY, $tenancyContract->id);
        return $user;
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return true;
    }

    /**
     * @param User $user
     * @param $password
     * @param $remember
     * @return array
     * @throws PalException
     */
    private function authAppend(User $user, $password, $remember){
        $tenancy = $user->tenancyContract;
        $pendingRequest = $this->getPendingRequest();
        $result = $pendingRequest->post($tenancy->login_endpoint, [
            'username' => $user->username,
            'password' => $password,
            'remember' => $remember
        ]);
        if($result->status() != 200){
            throw new PalException();
        }
        return $result->json();
    }

    /**
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|void|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $client = Redis::connection('session');
        $savedRemember = $client->get('remember_'.$token);
        if(empty($savedRemember)){
            return null;
        }
        $savedRemember = json_decode($savedRemember, true);
        session()->put(self::TENANCY_ID_KEY, $savedRemember['tenancy_id']);
        return parent::retrieveByToken($identifier, $token);
    }

    /**
     * @param Authenticatable $user
     * @param string $token
     * @return bool|void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $userRepository = app()->get(UserRepositoryInterface::class);
        $userModel = $userRepository->getUserByUsername($user->username);
        $client = Redis::connection('session');
        $client->set('remember_'.$token, json_encode(['tenancy_id' => $userModel->tenancy_contract_id]));
        return parent::updateRememberToken($user, $token);
    }
}
