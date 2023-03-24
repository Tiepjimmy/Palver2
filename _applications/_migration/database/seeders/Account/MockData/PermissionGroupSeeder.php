<?php

namespace Database\Seeders\Account\MockData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\User\Models\PermissionGroup;
use AccountSdkDb\Modules\User\Models\StorePermissionGroup;
use AccountSdkDb\Modules\User\Models\Assign;
use AccountSdkDb\Modules\User\Models\AssignPermissionGroup;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $listPermissionGroup = [
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý sản phẩm',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý nhà cung cấp',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý user',
                    'active_status' => 'active',
                    'group_type' => 'full',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý cơ cấu tổ chức',
                    'active_status' => 'active',
                    'group_type' => 'full',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý chức danh',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý kho',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý quyền',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý đơn hàng',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý đối soát',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý khuyến mại',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý khách hàng',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
                [
                    'subsystem_id' => 1,
                    'group_name' => 'Quản lý chủ đề',
                    'active_status' => 'active',
                    'group_type' => 'single',
                ],
            ];
            $listAssign = [
                [
                    'store_id' => 1,
                    'user_id' => 1,
                    'job_title_id' => 1,
                ],
                [
                    'store_id' => 2,
                    'user_id' => 2,
                    'job_title_id' => 4,
                ],
                [
                    'store_id' => 3,
                    'user_id' => 3,
                    'job_title_id' => 7,
                ],
                [
                    'store_id' => 4,
                    'user_id' => 4,
                    'job_title_id' => 10,
                ],
                [
                    'store_id' => 5,
                    'user_id' => 5,
                    'job_title_id' => 13,
                ],
                [
                    'store_id' => 6,
                    'user_id' => 6,
                    'job_title_id' => 16,
                ],
                [
                    'store_id' => 7,
                    'user_id' => 7,
                    'job_title_id' => 19,
                ],
                [
                    'store_id' => 8,
                    'user_id' => 8,
                    'job_title_id' => 22,
                ],
                [
                    'store_id' => 9,
                    'user_id' => 9,
                    'job_title_id' => 25,
                ],
                [
                    'store_id' => 10,
                    'user_id' => 10,
                    'job_title_id' => 28,
                ],

            ];
            $listAssignPermissionGroup = [
                [
                    'assign_id' => 1,
                    'permission_group_id' => 1
                ],
                [
                    'assign_id' => 2,
                    'permission_group_id' => 13
                ],
                [
                    'assign_id' => 3,
                    'permission_group_id' => 25
                ],
                [
                    'assign_id' => 4,
                    'permission_group_id' => 37
                ],
                [
                    'assign_id' => 5,
                    'permission_group_id' => 49
                ],
                [
                    'assign_id' => 6,
                    'permission_group_id' => 61
                ],
                [
                    'assign_id' => 7,
                    'permission_group_id' => 73
                ],
                [
                    'assign_id' => 8,
                    'permission_group_id' => 85
                ],
                [
                    'assign_id' => 9,
                    'permission_group_id' => 97
                ],
                [
                    'assign_id' => 10,
                    'permission_group_id' => 109
                ],
            ];
            for ($storeId = 1; $storeId <= 10; $storeId++) {
                foreach ($listPermissionGroup as $permissionGroup) {
                    PermissionGroup::updateOrCreate(array(
                        'subsystem_id' => $permissionGroup['subsystem_id'],
                        'group_name' => $permissionGroup['group_name'] . ' ' . $storeId,
                        'active_status' => $permissionGroup['active_status'],
                        'group_type' => $permissionGroup['group_type'],
                    ));
                }
                for ($permissionGroupId = 1; $permissionGroupId <= 12; $permissionGroupId++) {
                    StorePermissionGroup::updateOrCreate(array(
                        'store_id' => $storeId,
                        'permission_group_id' => ($storeId - 1) * 12 + $permissionGroupId
                    ));
                }
            }
            foreach ($listAssign as $assign) {
                Assign::updateOrCreate(array(
                    'store_id' => $assign['store_id'],
                    'user_id' => $assign['user_id'],
                    'job_title_id' => $assign['job_title_id'],
                ));
            }
            foreach ($listAssignPermissionGroup as $assignPermissionGroup) {
                AssignPermissionGroup::updateOrCreate(array(
                    'assign_id' => $assignPermissionGroup['assign_id'],
                    'permission_group_id' => $assignPermissionGroup['permission_group_id']
                ));
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
