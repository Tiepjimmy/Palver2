<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_system_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->char('setting_group_cd', 20)->comment('Mã nhóm cấu hình');
            $table->char('setting_cd', 20)->comment('Mã giá trị cấu hình');
            $table->string('setting_val', 255)->comment('Giá trị cấu hình hệ thống');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_system_settings` comment 'Cấu hình hệ thống'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_system_settings');
    }
}
