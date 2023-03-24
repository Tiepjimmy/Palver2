<?php

namespace Database\Seeders\Account\MockData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Store\Models\Store;

class StoreSeeder extends Seeder
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
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>1,
                    'parent_id'=>null,
                    'tree_path'=>'',
                    'store_name'=>'X-MEN',
                    'hotline'=>'18001999',
                    'address'=>'Phường Phúc Xá',
                    'active_status'=>'active',
                    'store_cd'=>'xmen001',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>2,
                    'parent_id'=>1,
                    'tree_path'=>'1/',
                    'store_name'=>'Chi nhánh 1',
                    'address'=>'Phường Trúc Bạch',
                    'hotline'=>'18001998',
                    'active_status'=>'active',
                    'store_cd'=>'xmen002',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>3,
                    'parent_id'=>2,
                    'tree_path'=>'1/2/',
                    'store_name'=>'Chi nhánh 1.1',
                    'address'=>'Phường Vĩnh Phúc',
                    'hotline'=>'18001997',
                    'active_status'=>'active',
                    'store_cd'=>'xmen003',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>6,
                    'parent_id'=>null,
                    'tree_path'=>'',
                    'store_name'=>'Đồng Hồ Rolex',
                    'address'=>'Phường Nguyễn Trung Trực',
                    'hotline'=>'19001999',
                    'active_status'=>'active',
                    'store_cd'=>'rolex01',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>5,
                    'parent_id'=>4,
                    'tree_path'=>'4/',
                    'store_name'=>'Chi nhánh 1',
                    'address'=>'Phường Liễu Giai',
                    'hotline'=>'18001998',
                    'active_status'=>'active',
                    'store_cd'=>'rolex02',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>4,
                    'parent_id'=>5,
                    'tree_path'=>'4/5/',
                    'store_name'=>'Chi nhánh 1.1',
                    'address'=>'Phường Cống Vị',
                    'hotline'=>'18001997',
                    'active_status'=>'active',
                    'store_cd'=>'rolex03',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>10,
                    'parent_id'=>null,
                    'tree_path'=>'',
                    'store_name'=>'Thời Trang Việt Nam',
                    'address'=>'Phường Đội Cấn',
                    'hotline'=>'0987654321',
                    'active_status'=>'active',
                    'store_cd'=>'vn0001',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>11,
                    'parent_id'=>7,
                    'tree_path'=>'7/',
                    'store_name'=>'Chi nhánh 1',
                    'address'=>'Phường Ngọc Khánh',
                    'hotline'=>'0987654322',
                    'active_status'=>'active',
                    'store_cd'=>'vn0002',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>12,
                    'parent_id'=>8,
                    'tree_path'=>'7/8/',
                    'store_name'=>'Chi nhánh 1.1',
                    'address'=>'Phường Kim Mã',
                    'hotline'=>'0987654324',
                    'active_status'=>'active',
                    'store_cd'=>'vn0003',
                ],
                [
                    'province_id'=>1,
                    'district_id'=>1,
                    'ward_id'=>8,
                    'parent_id'=>9,
                    'tree_path'=>'7/8/9/',
                    'store_name'=>'Chi nhánh 2',
                    'address'=>'Phường Quán Thánh',
                    'hotline'=>'0987654325',
                    'active_status'=>'active',
                    'store_cd'=>'vn0004',
                ],

            ];
            foreach ($stores as $value) {
                Store::updateOrCreate(array(
                    'province_id' => $value['province_id'],
                    'district_id' => $value['district_id'],
                    'ward_id' => $value['ward_id'],
                    'parent_id' => $value['parent_id'],
                    'tree_path' => $value['tree_path'],
                    'store_name' => $value['store_name'],
                    'address' => $value['address'],
                    'store_cd' => $value['store_cd'],
                    'hotline' => $value['hotline'],
                    'active_status' => $value['active_status'],

                ));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
