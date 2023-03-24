<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumeUnitsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_volume_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('volume_unit_id', 50)->comment('Tên đơn vị tính khối lượng');
            $table->char('volume_unit_cd', 20)->comment('Mã đơn vị khối lượng');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_volume_units` comment 'Loại đơn vị tính'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_volume_units');
    }
}
