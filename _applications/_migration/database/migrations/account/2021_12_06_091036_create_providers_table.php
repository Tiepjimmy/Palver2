<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->comment('Tỉnh thành');
            $table->integer('district_id')->comment('Quận huyện');
            $table->integer('ward_id')->comment('Phường xã');
            $table->char('provider_cd', 20)->comment('Mã nhà cung cấp');
            $table->string('provider_name', 256)->comment('Tên nhà cung cấp');
            $table->string('email', 256)->comment('Email của nhà cung cấp');
            $table->char('phone', 20)->comment('SDT liên hệ của NCC');
            $table->char('tax_cd', 20)->comment('Mã số thuế của nhà cung cấp')->nullable();
            $table->string('description', 1024)->comment('Mô tả chi tiết về NCC')->nullable();
            $table->string('address', 256)->comment('Địa chỉ nhà cung cấp');
            $table->enum('active_status', ['active','inactive'])->comment('Trạng thái nhà cung cấp');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_providers` comment 'Nhà cung cấp'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_providers');
    }
}
