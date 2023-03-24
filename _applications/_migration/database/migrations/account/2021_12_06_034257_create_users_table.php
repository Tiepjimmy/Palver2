<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->nullable()->comment('ID tỉnh thành phố');
            $table->integer('district_id')->nullable()->comment('ID quận huyện, phường xã');
            $table->integer('ward_id')->nullable()->comment('ID phường xã');
            $table->char('phone', 20)->comment('SĐT user');
            $table->enum('active_status', ['active','inactive'])->comment('Trạng thái (active, inactive)');
            $table->longText('avatar')->comment('Avatar của user (Base64)');
            $table->string('full_name', 255)->comment('Họ tên đầy đủ của user');
            $table->string('username', 255)->unique()->comment('Tên đăng nhập');
            $table->string('email', 255)->unique()->comment('Email của user');
            $table->string('password', 255)->comment('Password của user (đã mã hóa)');
            $table->boolean('is_owner')->comment('Là chủ của hệ thống (store)');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_users` comment 'Users'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_users');
    }
}
