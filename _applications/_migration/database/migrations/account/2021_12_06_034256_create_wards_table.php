<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_wards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('district_id')->comment('ID quận huyện');
            $table->string('ward_name', 255)->comment('Tên phường xã');
            $table->char('ward_cd', 20)->comment('Mã phường xã');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_wards` comment 'Phường xã'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_wards');
    }
}
