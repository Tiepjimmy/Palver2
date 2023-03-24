<?php

namespace App\Http\Providers;

use Common\Auth\AbstractPalUserProvider;
use Common\Auth\Models\SessionUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Cache;
use Nette\NotImplementedException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class PalUserProvider
 * @package App\Modules\Authentication\Providers
 */
class PalUserProvider extends AbstractPalUserProvider
{
    /**
     * @param mixed $identifier
     * @return Authenticatable|mixed|void|null
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function retrieveById($identifier)
    {
        if(Cache::has($identifier)){
            $cachedData = json_decode(Cache::get($identifier),true);
            $sessionUser = app()->make(SessionUser::class);
            $sessionUser->fill($cachedData);
            $sessionUser->jwt = $identifier;
            return $sessionUser;
        }
        $sessionUser = parent::retrieveById($identifier);
        Cache::put($identifier, json_encode($sessionUser), 60); //cache 1 min
        return $sessionUser;
    }



    /**
     * @param array $credentials
     * @return Authenticatable|mixed|void|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return null;
    }

    /**
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|void|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    /**
     * @param Authenticatable $user
     * @param string $token
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        throw new NotImplementedException(get_class($this));
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
}
