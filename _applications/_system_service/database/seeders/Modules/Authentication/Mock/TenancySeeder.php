<?php


namespace Database\Seeders\Modules\Authentication\Mock;

use App\Modules\Authentication\Models\TenancyContract;
use Database\Seeders\Modules\Authentication\Mock\Secrets\DemoSecrets;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenancySeeder extends Seeder
{
    public $masters = [
        [
            'id' => 1,
            'login_endpoint' => 'http://shop1.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop1.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop1.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop1.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 2,
            'login_endpoint' => 'http://shop2.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop2.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop2.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop2.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 3,
            'login_endpoint' => 'http://shop3.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop3.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop3.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop3.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 4,
            'login_endpoint' => 'http://shop4.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop4.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop4.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop4.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 5,
            'login_endpoint' => 'http://shop5.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop5.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop5.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop5.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 6,
            'login_endpoint' => 'http://shop6.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop6.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop6.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop6.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 7,
            'login_endpoint' => 'http://shop7.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop7.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop7.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop7.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 8,
            'login_endpoint' => 'http://shop8.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop8.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop8.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop8.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 9,
            'login_endpoint' => 'http://shop9.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop9.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop9.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop9.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ],
        [
            'id' => 10,
            'login_endpoint' => 'http://shop10.api-gateway.docker/account/v1/login',
            'logout_endpoint' => 'http://shop10.api-gateway.docker/account/v1/logout',
            'user_info_endpoint' => 'http://shop10.api-gateway.docker/account/v1/auth/info',
            'callback_endpoint'=> 'http://shop10.tuhav2.local/dashboard',
            'public_key' => DemoSecrets::public_key,
            'private_key' => DemoSecrets::private_key,
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host' => 'mariadb'
        ]
    ];

    /**
     * insert default user for phase01 and dev env
     * @throws \Exception
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            foreach ($this->masters as $tenancy) {
                TenancyContract::updateOrCreate($tenancy);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
