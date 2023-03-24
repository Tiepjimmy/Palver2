<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\PermissionGroups\Services\Impls;

use AccountSdkDb\Modules\Master\Models\Permission;
use AccountSdkDb\Modules\User\Models\PermissionGroup;
use AccountSdkDb\Modules\User\Models\PermissionPermissionGroup;

use App\Modules\PermissionGroups\Repositories\Contracts\PermissionGroupInterface;
use App\Modules\PermissionGroups\Repositories\Contracts\SubSystemInterface;
use App\Modules\PermissionGroups\Repositories\Contracts\StoreInterface;
use App\Modules\PermissionGroups\Repositories\Contracts\PermissionPermissionGroupInterface;
use App\Modules\PermissionGroups\Repositories\Contracts\StorePermissionGroupInterface;
use App\Modules\PermissionGroups\Services\IPermissionGroupsServices;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PermissionGroupsServices implements IPermissionGroupsServices
{
    protected $permissionGroupRepository;
    protected $subSystemRepository;
    protected $storeRepository;
    protected $storePermissionGroupRepository;
    protected $permissionPermissionGroupRepository;

    public function __construct(PermissionGroupInterface $permissionGroupRepository,
                                SubSystemInterface $subSystemRepository,
                                StoreInterface $storeRepository,
                                StorePermissionGroupInterface $storePermissionGroupRepository,
                                PermissionPermissionGroupInterface $permissionPermissionGroupRepository)
    {
        $this->permissionGroupRepository = $permissionGroupRepository;
        $this->subSystemRepository = $subSystemRepository;
        $this->storeRepository = $storeRepository;
        $this->storePermissionGroupRepository = $storePermissionGroupRepository;
        $this->permissionPermissionGroupRepository = $permissionPermissionGroupRepository;
    }
    
    /**
     * @inheritDoc
     */
    public function index($request = []) {
        $limit = $request['limit'] ?? 100;
        $validator = Validator::make($request, [
            'id-phan-he' => 'integer',
            'search' => 'string',
            'limit' => 'integer|max:100',
            'page' => 'integer'
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if (isset($request['search'])) {
            $storePermission = $this->storePermissionGroupRepository->getMore($request, array('groupBy' => ['permission_group_id']))->pluck('permission_group_id')->toArray();
            $request['search_id'] = $storePermission;
        }

        $permissionGroup = $this->permissionGroupRepository->getMore(
            $request,
            array(
                'with' => [
                    'permissions', 'stores', 'subsystem'
                ],
                'orderBy' => 'id'
            ), 
            $limit
        );

        return array(
            'total' => $permissionGroup->total(),
            'limit' => (int)$limit,
            'offset' => (int)$limit,
            'items' => $permissionGroup->items(),
        );
    }

    /**
     * @inheritDoc
     */
    public function create($request) {
        $subSystem = $this->subSystemRepository->getMore(
            array(),
            [
                'with' => ['features','features.permissions']
            ]
        );

        $store = $this->storeRepository->getAll();
        $headerStore = $this->storeRepository->getOne();

        $data = [
            'sub_system' => $subSystem->toArray(),
            'store' => $store,
            'header_store' => $headerStore
        ];

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function crudStore($input = [])
    {
        DB::beginTransaction();
        $dataRes = new \stdClass();
        try {
            $permissionGroup = $this->permissionGroupRepository->create($input);
            
            // Tạo Quyền nhóm quyền
            $input['permission_group_id'] = $permissionGroup->id;
            if ( is_array($input['permission_id']) ) {
                $ary['permission_group_id'] = $permissionGroup->id;
                foreach ( $input['permission_id'] as $permission_id) {
                    $ary['permission_id'] = $permission_id;
                    $this->permissionPermissionGroupRepository->create($ary);
                }
            } else {
                $this->permissionPermissionGroupRepository->create($input);
            }

            // Tạo tổ chức nhóm quyền
            if ( is_array($input['store_id']) ) {
                $ary['permission_group_id'] = $permissionGroup->id;
                foreach ( $input['store_id'] as $store_id) {
                    $ary['store_id'] = $store_id;
                    $this->storePermissionGroupRepository->create($ary);
                }
            } else {
                $this->storePermissionGroupRepository->create($input);
            }

            // event(new NhomQuyenInsertEvent($permissionGroup));

            DB::commit();
            $dataRes->status = 200;
            $dataRes->data = $permissionGroup;
            return $dataRes;
        } catch (\Exception $e) {
            DB::rollBack();
            $dataRes->status = 400;
            $dataRes->message = $e->getMessage();
            return $dataRes;
        }
    }

    /**
     * @inheritDoc
     */
    public function edit($id, $request) {
        $subSystem = $this->subSystemRepository->getMore(
            array(),
            [
                'with' => ['features','features.permissions']
            ]
        );

        $store = $this->storeRepository->getAll();
        $headerStore = $this->storeRepository->getOne();

        $permissionGroup = $this->permissionGroupRepository->getById(
            (int)$id,
            array(),
            array('with' => ['permissions', 'stores'])
        );

        $detail = $permissionGroup->toArray();

        $data = [
            'sub_system' => $subSystem->toArray(),
            'store' => $store,
            'header_store' => $headerStore,
            'detail' => $detail
        ];

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function crudUpdate($id, $input = [])
    {
        DB::beginTransaction();
        $dataRes = new \stdClass();
        try {
            $permissionGroup = $this->permissionGroupRepository->updateById($id, $input);
            
            // Tạo Quyền nhóm quyền
            $input['permission_group_id'] = $permissionGroup->id;
            $this->permissionPermissionGroupRepository->delByCond([
                'permission_group_id' => (int)$input['permission_group_id']
            ]);
            if ( is_array($input['permission_id']) ) {
                $ary['permission_group_id'] = $permissionGroup->id;
                foreach ( $input['permission_id'] as $permission_id) {
                    $ary['permission_id'] = $permission_id;
                    $this->permissionPermissionGroupRepository->create($ary);
                }
            } else {
                $this->permissionPermissionGroupRepository->create($input);
            }

            // Tạo tổ chức nhóm quyền
            $this->storePermissionGroupRepository->delByCond([
                'permission_group_id' => (int)$input['permission_group_id']
            ]);
            if ( is_array($input['store_id']) ) {
                $ary['permission_group_id'] = $permissionGroup->id;
                foreach ( $input['store_id'] as $store_id) {
                    $ary['store_id'] = $store_id;
                    $this->storePermissionGroupRepository->create($ary);
                }
            } else {
                $this->storePermissionGroupRepository->create($input);
            }

            // event(new NhomQuyenUpdatedEvent($nhomQuyen_old, $nhomQuyen));

            DB::commit();
            $dataRes->status = 200;
            $dataRes->data = $permissionGroup;
            return $dataRes;
        } catch (\Exception $e) {
            DB::rollBack();
            $dataRes->status = 400;
            $dataRes->message = $e->getMessage();
            return $dataRes;
        }
    }
    
    /**
     * @inheritDoc
     */
    public function createDefaultPermissionGroups() {
        $stores = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 21, 22, 23];
        $systems = [12, 13, 14, 15, 16, 17, 18, 19, 20, 24, 25, 26];

        $crudAdmin = PermissionGroup::updateOrCreate([
            'group_name' => 'Admin'
        ], [
            'active_status' => 'active',
            'group_type' => 'full',
            'subsystem_id' => 1
        ]);

        $permissions = Permission::all();
        foreach ( $permissions as $permission ) {
            PermissionPermissionGroup::updateOrCreate([
                'permission_id' => $permission->id,
                'permission_group_id' => $crudAdmin->id
            ]);
        }

        $crudStore = PermissionGroup::updateOrCreate([
            'group_name' => 'Nhân viên quản lý kho'
        ], [
            'active_status' => 'active',
            'group_type' => 'single',
            'subsystem_id' => 1
        ]);
        foreach ( $stores as $store ) {
            PermissionPermissionGroup::updateOrCreate([
                'permission_id' => $store,
                'permission_group_id' => $crudStore->id
            ]);
        }

        $crudSystem = PermissionGroup::updateOrCreate([
            'group_name' => 'Nhân viên quản lý hệ thống'
        ], [
            'active_status' => 'active',
            'group_type' => 'single',
            'subsystem_id' => 1
        ]);
        foreach ( $systems as $system ) {
            PermissionPermissionGroup::updateOrCreate([
                'permission_id' => $system,
                'permission_group_id' => $crudSystem->id
            ]);
        }
        
        return true;
    }
}
