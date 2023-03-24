<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OmSdk\System\Constants\LeadStatus;

class LeadStatusSeeder extends Seeder
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
                'id' => LeadStatus::CHO_CHAM_SOC,
                'store_id' => 1,
                'name' => 'Chờ chăm sóc',
                'code' => 'LS001',
                'color' => 'orange',
                'description' => 'Chờ chăm sóc',
                'level' => 1,
                'is_system' => 1,
                'is_default' => 0,
                'created_by' => 1
            ],
            [
                'id' => LeadStatus::SO_HUY,
                'store_id' => 1,
                'name' => 'Số hủy',
                'code' => 'LS002',
                'color' => 'brown',
                'description' => 'Số hủy',
                'level' => 1,
                'is_system' => 1,
                'is_default' => 1,
                'created_by' => 1
            ],
            [
                'id' => LeadStatus::DANG_CHAM_SOC,
                'store_id' => 1,
                'name' => 'Đang chăm sóc',
                'code' => 'LS003',
                'color' => 'red',
                'description' => 'Đang chăm sóc',
                'level' => 1,
                'is_system' => 1,
                'is_default' => 0,
                'created_by' => 1
            ],
            [
                'id' => LeadStatus::DA_TAO_DON,
                'store_id' => 1,
                'name' => 'Đã tạo đơn',
                'code' => 'LS004',
                'color' => 'green',
                'description' => 'Đã tạo đơn',
                'level' => 1,
                'is_system' => 1,
                'is_default' => 0,
                'created_by' => 1
            ],
            [
                'id' => LeadStatus::THAT_BAI,
                'store_id' => 1,
                'name' => 'Thất bại',
                'code' => 'LS005',
                'color' => 'green',
                'description' => 'Thất bại',
                'level' => 1,
                'is_system' => 1,
                'is_default' => 0,
                'created_by' => 1
            ]
        ];

        foreach ($data as $value) {
            $value['created_at'] = now();

            DB::table('om_marketing_lead_statuses')->updateOrInsert(
                [
                    'id' => $value['id']
                ],
                $value
            );
        }
    }
}
