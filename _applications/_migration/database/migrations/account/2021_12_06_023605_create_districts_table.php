<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->comment('ID tỉnh thành phố');
            $table->string('district_name', 255)->comment('Tên quận huyện');
            $table->char('district_cd', 20)->comment('Mã quận huyện theo trang chính phủ');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_districts` comment 'Quận huyện'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_districts');
    }
}
