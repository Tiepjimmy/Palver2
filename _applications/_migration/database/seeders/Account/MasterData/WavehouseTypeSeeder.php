<?php

namespace Database\Seeders\Account\MasterData;

use AccountSdkDb\Modules\Master\Models\WarehouseType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WavehouseTypeSeeder extends Seeder
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
            $wavehouseTypes = [
                [
                    'warehouse_type_name'=>'Kho tổng',
                    'warehouse_type_cd'=>'Kho_tong',
                    
                ],
                [
                    'warehouse_type_name'=>'Kho phụ',
                    'warehouse_type_cd'=>'Kho-phu',
                ],
            ];
            foreach ($wavehouseTypes as $wavehouseType) {
                WarehouseType::updateOrCreate(array(
                    'warehouse_type_name' => $wavehouseType['warehouse_type_name'],
                    'warehouse_type_cd' => $wavehouseType['warehouse_type_cd'],

                ));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
