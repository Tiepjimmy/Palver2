<?php


namespace Database\Seeders\Modules\Authentication\Mock;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    /**
     * insert default user for phase01 and dev env
     * @throws \Exception
     */
    public function run()
    {
        $tennacy = app()->make(TenancySeeder::class);
        try {
            DB::beginTransaction();
            foreach ($tennacy->masters as $index => $tenancy) {
                for ($i = 1; $i <= 10; $i++){
                    $shopName = $index+1;
                    User::updateOrCreate([
                        'tenancy_contract_id' => $tenancy['id'],
                        'username' => "shop{$shopName}_username{$i}"
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

}
