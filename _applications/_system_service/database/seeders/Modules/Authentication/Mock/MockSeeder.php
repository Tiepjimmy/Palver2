<?php


namespace Database\Seeders\Modules\Authentication\Mock;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class MockSeeder extends Seeder
{
    public $mock = [
        TenancySeeder::class,
        UserSeeder::class
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate');
        $this->call($this->mock);
    }

}
