<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTenancyContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_tenancy_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login_endpoint', 512)->nullable()->comment('API Login check');
            $table->string('logout_endpoint', 512)->nullable()->comment('API thực hiện logout');
            $table->string('callback_endpoint', 512)->nullable()->comment('URL đăng nhập sau khi login');
            $table->string('user_info_endpoint', 512)->nullable()->comment('Url lấy thông in user sau khi đăng nhập');
            $table->string('private_key', 4068)->nullable()->comment('Key mã hóa mặc định');
            $table->string('public_key', 4068)->nullable()->comment('Key giải mã mặc định');
            $table->string('db_username', 255)->nullable()->comment('User để đăng nhập vào db của khách hàng');
            $table->string('db_password', 255)->nullable()->comment('Password để đăng nhập vào db của khách hàng');
            $table->string('db_host', 128)->nullable()->comment('Mariadb host để đăng nhập vào db của khách hàng');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('t_tenancy_contracts');
    }
}
