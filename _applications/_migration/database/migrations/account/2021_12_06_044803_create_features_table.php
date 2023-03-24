<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subsystem_id')->comment('ID phân hệs');
            $table->string('feature_name', 64)->comment('Tên chức năng : Quản lý account, quản lý kho ...');
            $table->char('feature_cd', 20)->comment('Mã chức năng');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_features` comment 'Chức năng'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_features');
    }
}
