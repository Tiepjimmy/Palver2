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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AllShop1To10Seeder extends Seeder
{
    public $mock = [
        MasterDataSeeder::class,
        MockSeeder::class
    ];

    private $shop = ['shop1', 'shop2', 'shop3', 'shop4', 'shop5', 'shop6', 'shop7', 'shop8', 'shop9', 'shop10', ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->shop as $shop){
            $shopId = $shop;
            app()->bind('shop', function() use($shopId){
                return $shopId;
            });
            DB::purge('mysql');
            config()->set('database.connections.mysql.database', $shop);
            $this->command->info('Migrate && seed db for : ' . $shop);
            Artisan::call('migrate', array('--path' => 'database/migrations/account'));
            $this->call($this->mock);
        }
    }
}
