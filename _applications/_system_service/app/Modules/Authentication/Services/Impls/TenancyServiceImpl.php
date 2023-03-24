<?php


namespace App\Modules\Authentication\Services\Impls;


use App\Modules\Authentication\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Authentication\Services\ITenancyService;

/**
 * Class TenancyServiceImpl
 * @package App\Modules\Authentication\Services\Impls
 */
class TenancyServiceImpl implements ITenancyService
{
    private $userRepository;
    /**
     * TenancyServiceImpl constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $username
     * @return mixed|void
     */
    public function getCallbackUrlByUsername($username)
    {
        $user = $this->userRepository->getUserByUsername($username);
        return $user->tenancyContract->callback_endpoint;
    }
}
