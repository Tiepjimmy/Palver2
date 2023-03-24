<?php

namespace App\Modules\User\Services\Impls;

use App\Services\IHttpSysService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use App\Modules\User\Services\IUserService;
use App\Modules\User\Services\IAssignService;
use App\Modules\User\Events\UserInsertEvent;
use App\Modules\User\Events\UserUpdateEvent;
use App\Modules\User\Repositories\Contracts\UserInterface;
use App\Modules\Master\Repositories\Contracts\SubSystemInterface;
use App\Modules\Store\Repositories\Contracts\StoreInterface;
use Illuminate\Support\Facades\Http;

/**
 * @inheritDoc
 */
class UserServiceImplement implements IUserService
{
    protected $userRepository;
    protected $assignService;
    protected $subSystemRepository;
    protected $storeRepository;
    private $httpSysService;

    /**
     * UserServiceImplement constructor.
     * @param UserInterface $userRepository
     * @param IAssignService $assignService
     * @param StoreInterface $storeRepository
     * @param SubSystemInterface $subSystemRepository
     */
    public function __construct(UserInterface $userRepository,
                                IAssignService $assignService,
                                StoreInterface $storeRepository,
                                SubSystemInterface $subSystemRepository,
                                IHttpSysService $httpInterface
    )
    {
        $this->userRepository = $userRepository;
        $this->assignService = $assignService;
        $this->subSystemRepository = $subSystemRepository;
        $this->storeRepository = $storeRepository;
        $this->httpSysService = $httpInterface;

    }

    /**
     * @inheritDoc
     */
    public function search($keyword, $limit, $offset) {
        $totals = $this->userRepository->checkExist(
            array(
                'keyword' => $keyword
            ),
        );
        $listUser = $this->userRepository->getMore(
            array(
                'keyword' => $keyword
            ),
            array(
                'limit' => $limit,
                'offset' => $offset,
                'with' => array(
                    'assigns.store',
                    'assigns.permissionGroups',
                    'assigns.jobTitle',
                )
            )
        );
        return array(
            'items' => $listUser,
            'total' => $totals,
            'limit' => $limit,
            'offset' => $offset,
        );
    }

    /**
     * @inheritDoc
     */
    public function store($payload) {
        $validators = Validator::make($payload, array(
            'email' => 'required|email|unique:acc_t_users|string|max:255',
            'username' => 'required|unique:acc_t_users|string|max:255|is_username',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|is_phone_number',
            'password' => 'required|string|min:6|max:20',
            'password_confirmation' => 'required|same:password',
            'active_status' => 'required|in:active,inactive',
            'avatar' => 'required',
            'is_owner' => 'nullable',
            'province_id' => 'nullable',
            'district_id' => 'nullable',
            'commune_id' => 'nullable',
            'remember_token' => 'nullable',
            'store' => 'required',
            'store.*' => 'required|numeric',
            'job_title' => 'required',
            'job_title.*' => 'required|numeric',
            'job_title_group' => 'required',
            'job_title_group.*' => 'required|in:manager,staff,other',
            'permission_group' => 'required',
            'permission_group.*' => 'required|numeric',
        ),
        array(
            'password_confirmation.same' => 'Trường xác nhận mật khẩu không đúng'
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $storedUser = null;
        $createdAssign = null;
        $createdAssignPermission = null;
        try {
            DB::beginTransaction();
            $storedUser = $this->userRepository->create(array(
                'email' => $payload['email'],
                'full_name' => $payload['full_name'],
                'username' => $payload['username'],
                'phone' => $payload['phone'],
                'password' => Hash::make($payload['password']),
                'active_status' => $payload['active_status'],
                'avatar' => $payload['avatar'],
                'is_owner' => $payload['is_owner'] ?? false,
            ));
            if (!empty($storedUser)){
                $param = [
                    'creator'=> Auth::user()->username,
                    'username' => $storedUser->username
                ];
                $apiService = $this->httpSysService->post('/async-account',$param);
                if (empty($apiService)) {
                    throw new PalException('E000001');
                }
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new PalException('E000001');
        }

        $listStore = $payload['store'];
        $listJobTitle = $payload['job_title'];
        $listPermissionGroup = $payload['permission_group'];

        $this->assignService->addAssign($storedUser->id, $listStore, $listJobTitle, $listPermissionGroup);
        if (!is_null($storedUser)) {
            Event::dispatch(new UserInsertEvent($storedUser));
        } else {
            throw new PalException('E000001');
        }

        return $storedUser;
    }

    /**
     * @inheritDoc
     */
    public function getCreateInfos() {
        $store = $this->storeRepository->getMore(array(), array(
            'with' => array(
                'jobTitles',
                'permissionGroups',
            )
        ));
        $subSystem = $this->subSystemRepository->getMore(array(), array(
            'with' => array(
                'features.permissions.permissionPermissionGroups.permissionGroup.storePermissionGroups.stores'
            )
        ));

        return array(
            'sub_system' => $subSystem,
            'store' => $store
        );
    }

    /**
     * @inheritDoc
     */
    public function show($userId) {
        $validators = Validator::make(array(
            'user_id' => $userId
        ), array(
            'user_id' => "required|exists:acc_t_users,id",
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }
        return $this->userRepository->getById($userId, array(), array(
            'with' => array(
                'assigns.store',
                'assigns.permissionGroups',
                'assigns.jobTitle',
            )
        ));
    }

    /**
     * @inheritDoc
     */
    public function update($id, $payload) {
        $validators = Validator::make($payload, array(
            'email' => "required|email|unique:acc_t_users,email,{$id}|string|max:255",
            'username' => "required|unique:acc_t_users,username,{$id}|string|max:255|is_username",
            'full_name' => 'required|string|max:255',
            'phone' => 'required|is_phone_number',
            'password' => 'nullable|string|min:6|max:20',
            'password_confirmation' => 'nullable|required_with:password|same:password',
            'active_status' => 'required|in:active,inactive',
            'avatar' => 'required',
            'is_owner' => 'nullable',
            'province_id' => 'nullable',
            'district_id' => 'nullable',
            'commune_id' => 'nullable',
            'remember_token' => 'nullable',
            'store' => 'required',
            'store.*' => 'required|numeric',
            'job_title' => 'required',
            'job_title.*' => 'required|numeric',
            'job_title_group' => 'required',
            'job_title_group.*' => 'required|in:manager,staff,other',
            'permission_group' => 'required',
            'permission_group.*' => 'required|numeric',
        ),
        array(
            'password_confirmation.same' => 'Trường xác nhận mật khẩu không đúng'
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $updatedUser = null;
        $createdAssign = null;
        $createdAssignPermission = null;

        $updateData = array(
            'email' => $payload['email'],
            'full_name' => $payload['full_name'],
            'username' => $payload['username'],
            'phone' => $payload['phone'],
            'password' => $payload['password'] ? Hash::make($payload['password']) : null,
            'active_status' => $payload['active_status'],
            'avatar' => $payload['avatar'],
            'is_owner' => $payload['is_owner'] ?? false,
        );
        if (is_null($updateData['password'])) {
            unset($updateData['password']);
        }
        $userold = $this->userRepository->getById($id);
        try {
            DB::beginTransaction();
            $updatedUser = $this->userRepository->updateById($id, $updateData);
            if (!empty($updatedUser)) {
                $param = [
                    'creator'=> Auth::user()->username,
                    'username-old' => $userold->username,
                    'username-new' => $updatedUser->username
                ];
                $apiService = $this->httpSysService->post('/async-account/update',$param);
                if (empty($apiService)) {
                    throw new PalException('E000001');
                }
                DB::commit();
            }
        }catch (\Exception $e){
            DB::rollBack();
            throw new PalException('E000001');
        }
        $listStore = $payload['store'];
        $listJobTitle = $payload['job_title'];
        $listPermissionGroup = $payload['permission_group'];

        $this->assignService->removeAssign($id);
        $this->assignService->addAssign($id, $listStore, $listJobTitle, $listPermissionGroup);

        if (!is_null($updatedUser)) {
            Event::dispatch(new UserInsertEvent($updatedUser));
        } else {
            throw new PalException('E000001');
        }

        return $updatedUser;
    }

    /**
     * @inheritDoc
     */
    public function updateStatus($id, $payload) {
        $validators = Validator::make($payload, array(
            'active_status' => 'required|in:active,inactive'
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }
        $updatedUserStatus = null;
        $updatedUserStatus = $this->userRepository->updateById($id, array(
            'active_status' => $payload['active_status']
        ));

        if (!is_null($updatedUserStatus)) {
            Event::dispatch(new UserUpdateEvent($updatedUserStatus));
        } else {
            throw new PalException('E000001');
        }

        return $updatedUserStatus;
    }
}
