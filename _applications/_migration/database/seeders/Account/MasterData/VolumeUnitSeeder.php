<?php

namespace Database\Seeders\Account\MasterData;

use AccountSdkDb\Modules\Master\Models\VolumeUnit;
use Illuminate\Database\Seeder;

class VolumeUnitSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $master = [
            ['id' => 1, 'volume_unit_id'=> 'g', 'volume_unit_cd'=> 'g'],
            ['id' => 2, 'volume_unit_id'=> 'kg', 'volume_unit_cd'=> 'kg'],
            ['id' => 3, 'volume_unit_id'=> 'ml', 'volume_unit_cd'=> 'ml']
        ];

        foreach ($master as $item){
            VolumeUnit::updateOrCreate($item);
        }
    }
}
