<?php

namespace Database\Seeders\Account\MasterData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Master\Models\Province;
use AccountSdkDb\Modules\Master\Models\District;
use AccountSdkDb\Modules\Master\Models\Ward;

class AddressSeeder extends Seeder
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
            $path = 'https://provinces.open-api.vn/api/?depth=3';
            $jsonData = json_decode(file_get_contents($path), true);
            foreach ( $jsonData as $provinces ) {
                $crudProvince = Province::updateOrCreate([
                    'province_cd' => $provinces['code']
                ],
                [
                    'province_name' => $provinces['name']
                ]);
                foreach ( $provinces['districts'] as $districts ) {
                    $crudDistrict = District::updateOrCreate([
                        'district_cd' => $districts['code']
                    ], [
                        'province_id' => $crudProvince->id,
                        'district_name' => $districts['name']
                    ]);
                    foreach ( $districts['wards'] as $wards ) {
                        Ward::updateOrCreate([
                            'ward_cd' => $wards['code']
                        ], [
                            'district_id' => $crudDistrict->id,
                            'ward_name' => $wards['name']
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
