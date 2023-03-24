<?php

namespace Database\Seeders\Account;

use Database\Seeders\Account\MasterData\AddressSeeder;
use Database\Seeders\Account\MasterData\AttributeTypeSeeder;
use Database\Seeders\Account\MasterData\PermissionSeed;
use Database\Seeders\Account\MasterData\VolumeUnitSeeder;
use Database\Seeders\Account\MasterData\WavehouseTypeSeeder;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public $masters = [
        AddressSeeder::class,
        AttributeTypeSeeder::class,
        PermissionSeed::class,
        VolumeUnitSeeder::class,
        WavehouseTypeSeeder::class
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call($this->masters);
    }
}
