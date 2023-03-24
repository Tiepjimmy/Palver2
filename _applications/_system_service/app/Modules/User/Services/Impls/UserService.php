<?php


namespace App\Modules\User\Services\Impls;


use App\Modules\User\Repositories\Contracts\TenancyContractRepositoryInterface;
use App\Modules\User\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\User\Services\IUserService;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use Illuminate\Support\Facades\Validator;

class UserService implements IUserService
{
    protected $userRepository;
    public function __construct(
        UserRepositoryInterface $userInterface)
    {
        $this->userRepository = $userInterface;
    }

    /**
     * @inheritDoc
     */
    public function store($attributes)
    {

        $validators = Validator::make($attributes, array(
            'creator' => 'required',
            'username' => 'required',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }
        $checkCreator = $this->userRepository->getUserByUsername($attributes['creator']);
        if (empty($checkCreator)) {
            throw new PalException('E000001');
        }
        $params = [
            'tenancy_contract_id' => $checkCreator->tenancy_contract_id,
            'username' => $attributes['username'],
        ];
        $store = $this->userRepository->create($params);
        return $store;
    }

    /**
     * @inheritDoc
     */
    public function update($attributes)
    {
        $validators = Validator::make($attributes, array(
            'creator' => 'required',
            'username-new' => 'required',
            'username-old' => 'required',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }
        $checkCreator = $this->userRepository->getUserByUsername($attributes['creator']);
        if (empty($checkCreator)) {
            throw new PalException('E000001');
        }
        $checkUserOld = $this->userRepository->getUserByUsername($attributes['username-old']);
        if (empty($checkUserOld)) {
            throw new PalException('E000001');
        }
        $params = [
            'username' => $attributes['username-new'],
        ];
        $update = $this->userRepository->updateById($checkUserOld->id,$params);
        return $update;
    }
}
