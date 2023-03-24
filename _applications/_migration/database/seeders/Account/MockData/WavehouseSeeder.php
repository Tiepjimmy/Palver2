<?php

namespace Database\Seeders\Account\MockData;

use AccountSdkDb\Modules\Warehouse\Models\Warehouse;
use AccountSdkDb\Modules\Warehouse\Models\WarehouseStore;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WavehouseSeeder extends Seeder
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
            $stores = [
                [
                    'warehouse_type_id'=>1,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho cầu giấy',
                    'note'=>'Kho hà nội',
                    'address'=>'Cầu giấy',
                    'hotline'=>'0987654321',
                    'warehouse_cd'=>'HN0001',
                ],
                [
                    'warehouse_type_id'=>1,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho thanh xuân',
                    'note'=>'Kho thanh xuân',
                    'address'=>'Thanh xuân',
                    'hotline'=>'0987654322',
                    'warehouse_cd'=>'HN0002',
                ],
                [
                    'warehouse_type_id'=>1,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho hà đông',
                    'note'=>'Kho hà đông',
                    'address'=>'Hà đông',
                    'hotline'=>'0987654323',
                    'warehouse_cd'=>'HN0003',
                ],
                [
                    'warehouse_type_id'=>2,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Đống đa',
                    'note'=>'Kho đống đa',
                    'address'=>'Đống đa',
                    'hotline'=>'0987654324',
                    'warehouse_cd'=>'HN0004',
                ],
                [
                    'warehouse_type_id'=>2,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho thạch thất',
                    'note'=>'Kho thạch thất',
                    'address'=>'Thạch thất',
                    'hotline'=>'0987654325',
                    'warehouse_cd'=>'HN0005',
                ],
                [
                    'warehouse_type_id'=>2,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho đông anh',
                    'note'=>'Kho đông anh',
                    'address'=>'Đông anh',
                    'hotline'=>'0987654326',
                    'warehouse_cd'=>'HN0006',
                ],
                [
                    'warehouse_type_id'=>1,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho long biên',
                    'note'=>'Kho long biên',
                    'address'=>'long biên',
                    'hotline'=>'0987654327',
                    'warehouse_cd'=>'HN0007',
                ],
                [
                    'warehouse_type_id'=>2,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho gia lâm',
                    'note'=>'Kho gia lâm',
                    'address'=>'Gia lâm',
                    'hotline'=>'0987654328',
                    'warehouse_cd'=>'HN0008',
                ],
                [
                    'warehouse_type_id'=>1,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Kho chương mỹ',
                    'note'=>'Kho chương mỹ',
                    'address'=>'Chương mỹ',
                    'hotline'=>'0987654329',
                    'warehouse_cd'=>'HN0009',
                ],
                [
                    'warehouse_type_id'=>2,
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'warehouse_name'=>'Sóc sơn',
                    'note'=>'Kho sóc sơn',
                    'address'=>'Sóc sơn',
                    'hotline'=>'0987654310',
                    'warehouse_cd'=>'HN0010',
                ],

            ];
            $i = 0;
            foreach ($stores as $value) {
                $wavehouse = Warehouse::updateOrCreate(array(
                    'warehouse_type_id' => $value['warehouse_type_id'],
                    'province_id' => $value['province_id'],
                    'district_id' => $value['district_id'],
                    'ward_id' => $value['ward_id'],
                    'warehouse_name' => $value['warehouse_name'],
                    'note' => $value['note'],
                    'address' => $value['address'],
                    'hotline' => $value['hotline'],
                    'warehouse_cd' => $value['warehouse_cd'],

                ));
                if (!empty($wavehouse)) {
                    WarehouseStore::updateOrCreate(array(
                        'store_id' => ++$i,
                        'warehouse_id' => $wavehouse->id
                    ));
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
