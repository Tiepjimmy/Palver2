<?php

namespace Database\Seeders\Account;

use Database\Seeders\Account\MasterData\PermissionSeed;
use Database\Seeders\Account\MockData\JobTitleSeeder;
use Database\Seeders\Account\MockData\ProductAttributeSeeder;
use Database\Seeders\Account\MockData\ProductCatalogsSeeder;
use Database\Seeders\Account\MockData\ProductsSeeder;
use Database\Seeders\Account\MockData\ProviderSeeder;
use Database\Seeders\Account\MockData\StoreSeeder;
use Database\Seeders\Account\MockData\UserSeeder;
use Database\Seeders\Account\MockData\WavehouseSeeder;
use Database\Seeders\Account\MockData\PermissionGroupSeeder;
use Illuminate\Database\Seeder;

class MockSeeder extends Seeder
{
    public $mock = [
        JobTitleSeeder::class,
        PermissionSeed::class,
        ProductAttributeSeeder::class,
        ProductCatalogsSeeder::class,
        ProviderSeeder::class,
        ProductsSeeder::class,
        StoreSeeder::class,
        UserSeeder::class,
        WavehouseSeeder::class,
        PermissionGroupSeeder::class
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call($this->mock);
    }
}
