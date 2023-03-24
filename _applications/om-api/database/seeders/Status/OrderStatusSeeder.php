<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OmSdk\System\Constants\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => OrderStatus::TAO_MOI,
                'store_id' => 1,
                'name' => 'Tạo mới',
                'action_name' => 'Tạo mới đơn hàng đặt trước',
                'code' => 'OS001',
                'color' => '#bb430a',
                'description' => 'Tạo mới đơn hàng đặt trước',
                'level' => OrderStatus::LEVEL_1,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 1,
                'type' => 2,
                'created_by' => 1
            ], [
                'id' => OrderStatus::DA_LEN_DON,
                'store_id' => 1,
                'name' => 'Đã lên đơn',
                'action_name' => 'Tạo đơn hàng có sẵn',
                'code' => 'OS002',
                'color' => '#bb430a',
                'description' => 'Tạo đơn hàng có sẵn',
                'level' => OrderStatus::LEVEL_2,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 2,
                'created_by' => 1
            ],
            [
                'id' => OrderStatus::XAC_NHAN_CHOT_DON,
                'store_id' => 1,
                'name' => 'Xác nhận - Chốt đơn',
                'action_name' => 'Tạo đơn hàng',
                'code' => 'OS003',
                'color' => 'green',
                'description' => 'Tạo đơn hàng',
                'level' => OrderStatus::LEVEL_3,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 1,
                'created_by' => 1
            ], [
                'id' => OrderStatus::KE_TOAN_MAC_DINH,
                'store_id' => 1,
                'name' => 'Kế toán mặc định',
                'action_name' => 'Duyệt đơn hàng',
                'code' => 'OS004',
                'color' => '#6aafd7',
                'description' => '(Đơn đã duyệt)',
                'level' => OrderStatus::LEVEL_4,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 1,
                'created_by' => 1
            ], [
                'id' => OrderStatus::HUY_DON,
                'store_id' => 1,
                'name' => 'Hủy đơn',
                'action_name' => 'Hủy đơn hàng',
                'code' => 'OS005',
                'color' => 'red',
                'description' => 'Hủy đơn hàng',
                'level' => OrderStatus::LEVEL_4,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 1,
                'created_by' => 1
            ], [
                'id' => OrderStatus::CHUYEN_HANG,
                'store_id' => 1,
                'name' => 'Chuyển hàng',
                'action_name' => 'Xác nhận chuyển hàng',
                'code' => 'OS006',
                'color' => 'brown',
                'description' => '(Đóng gói)',
                'level' => OrderStatus::LEVEL_5,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 1,
                'created_by' => 1
            ], [
                'id' => OrderStatus::THIEU_HANG,
                'store_id' => 1,
                'name' => 'Thiếu hàng',
                'action_name' => 'Xác nhận thiếu hàng',
                'code' => 'OS007',
                'color' => 'brown',
                'description' => 'Xác nhận thiếu hàng',
                'level' => OrderStatus::LEVEL_6,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 1,
                'type' => 1,
                'created_by' => 1
            ], [
                'id' => OrderStatus::DA_XUAT_KHO,
                'store_id' => 1,
                'name' => 'Đã xuất kho',
                'action_name' => 'Xác nhận xuất kho',
                'code' => 'OS008',
                'color' => '#06640d',
                'description' => 'Xác nhận xuất kho',
                'level' => OrderStatus::LEVEL_6,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 1,
                'type' => 1,
                'created_by' => 1
            ], [

                'id' => OrderStatus::GIAO_HANG_THANH_CONG,
                'store_id' => 1,
                'name' => 'Giao hàng thành công',
                'action_name' => 'Hoàn thành',
                'code' => 'OS009',
                'color' => '#06640d',
                'description' => 'Giao hàng thành công',
                'level' => OrderStatus::LEVEL_7,
                'is_system' => 7,
                'is_active' => 1,
                'is_no_revenue' => 1,
                'type' => 1,
                'created_by' => 1
            ], [
                'id' => OrderStatus::CHUYEN_HOAN,
                'store_id' => 1,
                'name' => 'Chuyển hoàn',
                'action_name' => 'Hoàn thành đơn hàng',
                'code' => 'OS010',
                'color' => '#bb430a',
                'description' => 'Hoàn thành đơn hàng',
                'level' => OrderStatus::LEVEL_7,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 1,
                'type' => 1,
                'created_by' => 1
            ], [
                'id' => OrderStatus::KHO_DA_NHAP_HANG_HOAN,
                'store_id' => 1,
                'name' => 'Kho đã nhập hàng hoàn',
                'action_name' => 'Xác nhận nhập kho hàng hoàn',
                'code' => 'OS011',
                'color' => '#bb430a',
                'description' => 'Kho đã nhập hàng hoàn',
                'level' => OrderStatus::LEVEL_2,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 3,
                'created_by' => 1
            ], [
                'id' => OrderStatus::HUY_DON_DAT_TRUOC,
                'store_id' => 1,
                'name' => 'Hủy đơn',
                'action_name' => 'Hủy đơn hàng đặt trước',
                'code' => 'OS012',
                'color' => '#bb430a',
                'description' => 'Hủy đơn hàng đặt trước',
                'level' => OrderStatus::LEVEL_2,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 2,
                'created_by' => 1
            ], [
                'id' => OrderStatus::CHUYEN_HOAN_CHO_NHAP_KHO,
                'store_id' => 1,
                'name' => 'Chuyển hoàn chờ nhập kho',
                'action_name' => 'Tạo đơn hàng',
                'code' => 'OS013',
                'color' => '#bb430a',
                'description' => 'Chuyển hoàn chờ nhập kho',
                'level' => OrderStatus::LEVEL_1,
                'is_system' => 1,
                'is_active' => 1,
                'is_no_revenue' => 0,
                'type' => 3,
                'created_by' => 1
            ]
        ];

        foreach ($data as $value) {
            $value['created_at'] = now();

            DB::table('om_order_statuses')->updateOrInsert(
                [
                    'id' => $value['id']
                ],
                $value
            );
        }
    }
}
