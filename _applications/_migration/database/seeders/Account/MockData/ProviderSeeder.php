<?php

namespace Database\Seeders\Account\MockData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Provider\Models\Provider;
use AccountSdkDb\Modules\Provider\Models\StoreProvider;
use AccountSdkDb\Modules\Provider\Models\ProviderGroup;
use AccountSdkDb\Modules\Provider\Models\ProviderProviderGroup;

class ProviderSeeder extends Seeder
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
            $listProviderGroup = [
                [
                    'group_name' => 'Nhóm nhà cung cấp 1',
                    'group_cd' => 'NNCC01',
                    'note' => 'Nhóm nhà cung cấp hàng hóa số 1',
                ],
                [
                    'group_name' => 'Nhóm nhà cung cấp 2',
                    'group_cd' => 'NNCC02',
                    'note' => 'Nhóm nhà cung cấp hàng hóa số 2',
                ],
                [
                    'group_name' => 'Nhóm nhà cung cấp 3',
                    'group_cd' => 'NNCC03',
                    'note' => 'Nhóm nhà cung cấp hàng hóa số 3',
                ],
            ];
            foreach ($listProviderGroup as $providerGroup) {
                for ($storeId = 1; $storeId <= 10; $storeId++) {
                    ProviderGroup::updateOrCreate([
                        'store_id' => $storeId,
                        'group_name' => $providerGroup['group_name'] . ' tổ chức ' . $storeId,
                        'group_cd' => $providerGroup['group_cd'] . $storeId,
                        'note' => $providerGroup['note'] . ' tổ chức ' . $storeId,
                    ]);
                }
            }
            $listProvider = [
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC1-1',
                    'provider_name' => 'Nhà cung cấp 1-1',
                    'email' => 'ncc1@gmail.com',
                    'phone' => '0978999901',
                    'tax_cd' => 'NCC000001',
                    'description' => 'Nhà cung cấp 1 thuộc nhóm nhà cung cấp 1',
                    'address' => 'Số 1 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC2-1',
                    'provider_name' => 'Nhà cung cấp 2-1',
                    'email' => 'ncc2@gmail.com',
                    'phone' => '0978999902',
                    'tax_cd' => 'NCC000002',
                    'description' => 'Nhà cung cấp 2 thuộc nhóm nhà cung cấp 1',
                    'address' => 'Số 2 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC3-1',
                    'provider_name' => 'Nhà cung cấp 3-1',
                    'email' => 'ncc3@gmail.com',
                    'phone' => '0978999903',
                    'tax_cd' => 'NCC000003',
                    'description' => 'Nhà cung cấp 3 thuộc nhóm nhà cung cấp 1',
                    'address' => 'Số 3 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC4-2',
                    'provider_name' => 'Nhà cung cấp 4-2',
                    'email' => 'ncc4@gmail.com',
                    'phone' => '0978999904',
                    'tax_cd' => 'NCC000004',
                    'description' => 'Nhà cung cấp 4 thuộc nhóm nhà cung cấp 2',
                    'address' => 'Số 4 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC5-2',
                    'provider_name' => 'Nhà cung cấp 5-2',
                    'email' => 'ncc5@gmail.com',
                    'phone' => '0978999905',
                    'tax_cd' => 'NCC000005',
                    'description' => 'Nhà cung cấp 5 thuộc nhóm nhà cung cấp 2',
                    'address' => 'Số 5 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC6-2',
                    'provider_name' => 'Nhà cung cấp 6-2',
                    'email' => 'ncc6@gmail.com',
                    'phone' => '0978999906',
                    'tax_cd' => 'NCC000006',
                    'description' => 'Nhà cung cấp 6 thuộc nhóm nhà cung cấp 2',
                    'address' => 'Số 6 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC7-3',
                    'provider_name' => 'Nhà cung cấp 7-3',
                    'email' => 'ncc7@gmail.com',
                    'phone' => '0978999907',
                    'tax_cd' => 'NCC000007',
                    'description' => 'Nhà cung cấp 7 thuộc nhóm nhà cung cấp 3',
                    'address' => 'Số 7 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC8-3',
                    'provider_name' => 'Nhà cung cấp 8-3',
                    'email' => 'ncc8@gmail.com',
                    'phone' => '0978999908',
                    'tax_cd' => 'NCC000008',
                    'description' => 'Nhà cung cấp 8 thuộc nhóm nhà cung cấp 3',
                    'address' => 'Số 8 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC9-3',
                    'provider_name' => 'Nhà cung cấp 9-3',
                    'email' => 'ncc9@gmail.com',
                    'phone' => '0978999909',
                    'tax_cd' => 'NCC000009',
                    'description' => 'Nhà cung cấp 9 thuộc nhóm nhà cung cấp 3',
                    'address' => 'Số 9 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
                [
                    'province_id' => 1,
                    'district_id' => 1,
                    'ward_id' => 1,
                    'provider_cd' => 'NCC10-3',
                    'provider_name' => 'Nhà cung cấp 10-3',
                    'email' => 'ncc10@gmail.com',
                    'phone' => '0978999910',
                    'tax_cd' => 'NCC000010',
                    'description' => 'Nhà cung cấp 10 thuộc nhóm nhà cung cấp 3',
                    'address' => 'Số 10 đường Nguyễn Trãi, Thanh Xuân, Hà Nội',
                    'active_status' => 'active',
                ],
            ];
            foreach ($listProvider as $provider) {
                Provider::updateOrCreate(array(
                    'province_id' => $provider['province_id'],
                    'district_id' => $provider['district_id'],
                    'ward_id' => $provider['ward_id'],
                    'provider_cd' => $provider['provider_cd'],
                    'provider_name' => $provider['provider_name'],
                    'email' => $provider['email'],
                    'phone' => $provider['phone'],
                    'tax_cd' => $provider['tax_cd'],
                    'description' => $provider['description'],
                    'address' => $provider['address'],
                    'active_status' => $provider['active_status'],
                ));
            }
            for ($storeId = 1; $storeId <= 10; $storeId++) {
                for ($providerId = 1; $providerId <= 10; $providerId++) {
                    StoreProvider::updateOrCreate(array(
                        'store_id' => $storeId,
                        'provider_id' => $providerId
                    ));
                }
            }
            $listProviderProviderGroup = [
                [
                    'provider_id' => 1,
                    'provider_group_id' => 1,
                ],
                [
                    'provider_id' => 2,
                    'provider_group_id' => 1,
                ],
                [
                    'provider_id' => 3,
                    'provider_group_id' => 1,
                ],
                [
                    'provider_id' => 4,
                    'provider_group_id' => 2,
                ],
                [
                    'provider_id' => 5,
                    'provider_group_id' => 2,
                ],
                [
                    'provider_id' => 6,
                    'provider_group_id' => 2,
                ],
                [
                    'provider_id' => 7,
                    'provider_group_id' => 3,
                ],
                [
                    'provider_id' => 8,
                    'provider_group_id' => 3,
                ],
                [
                    'provider_id' => 9,
                    'provider_group_id' => 3,
                ],
                [
                    'provider_id' => 10,
                    'provider_group_id' => 3,
                ],
            ];
            foreach ($listProviderProviderGroup as $providerProviderGroup) {
                ProviderProviderGroup::updateOrCreate(array(
                    'provider_id' => $providerProviderGroup['provider_id'],
                    'provider_group_id' => $providerProviderGroup['provider_group_id'],
                ));
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
