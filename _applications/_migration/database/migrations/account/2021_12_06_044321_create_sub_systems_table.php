<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubSystemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_subsystems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subsystem_name', 64)->comment('Tên phân hệ : account, inventory, OM');
            $table->char('subsystem_cd', 20)->comment('Mã phân hệ : acc, in, om');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_subsystems` comment 'Phân hệ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_subsystems');
    }
}
