<?php


namespace App\Modules\Authentication\Services\Impls;


use AccountSdkDb\Modules\Authentication\Services\ISessionExtendService;
use AccountSdkDb\Modules\User\Repositories\Contracts\UserTokenInterface;
use App\Exceptions\AuthFailException;
use App\Modules\Authentication\Events\LoginEvent;
use App\Modules\Authentication\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Authentication\Services\IAuthService;
use App\Modules\Authentication\Services\ISecretProvider;
use Common\Auth\Models\SessionUser;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 * @package App\Modules\Authentication\Services\Impls
 */
class AuthService implements IAuthService
{
    private $userRepository;
    private $secretProvider;
    private $userTokenRepository;
    private $sessionExtendService;

    /**
     * AuthService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param ISecretProvider $secretProvider
     * @param UserTokenInterface $userTokenRepository
     * @param ISessionExtendService $sessionExtendService
     */
    public function __construct(UserRepositoryInterface $userRepository,
        ISecretProvider $secretProvider,
        UserTokenInterface $userTokenRepository,
        ISessionExtendService $sessionExtendService)
    {
        $this->userRepository = $userRepository;
        $this->secretProvider = $secretProvider;
        $this->userTokenRepository = $userTokenRepository;
        $this->sessionExtendService = $sessionExtendService;
    }

    /**
     * @param $username
     * @param $password
     * @param bool $remember
     * @return string|null
     * @throws AuthFailException
     * @throws BindingResolutionException
     */
    public function attempt($username, $password, $remember = false)
    {
        $user = $this->userRepository->getUserByUsername($username);
        if(is_null($user)){
            throw new AuthFailException();
        }
        if(!Hash::check($password, $user->password)){
            throw new AuthFailException();
        }

        //create jwt
        $userToken = $this->createUserToken($user, is_null($remember) ? false : $remember);
        $payload = [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['ten'],
            'username' => $user['username'],
            'jti' => $userToken->jti,
            'iat' => now()->timestamp,
        ];
        $jwt = JWT::encode($payload, $this->secretProvider->getPrivateKey(), ISecretProvider::ENCRYPT_LOGIC);

        //fire event
        $userModel = app()->make(SessionUser::class);
        $userModel->fill($payload);
        LoginEvent::dispatch($userModel);
        return $jwt;
    }

    /**
     * @param $userInfo
     * @param $isLongtime
     * @return mixed
     */
    private function createUserToken($userInfo, $isLongtime){
        $jti = uniqid('', true);
        $userTokenData = [
            'jti' => $jti,
            'user_id' => $userInfo['id'],
            'is_longtime' => $isLongtime,
            'expires_at' =>  $isLongtime ? null : now()->addSeconds(config('sso.lifetime'))
        ];
        $this->userTokenRepository->create($userTokenData);
        $this->sessionExtendService->extendJTI($jti);
        return $this->userTokenRepository->getByJTI($jti);
    }
}