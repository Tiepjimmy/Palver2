<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province_name')->comment('Tên tỉnh thành phố');
            $table->char('province_cd', 20)->comment('Code thành phố lấy từ trang chính phủ');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_provinces` comment 'Tỉnh thành'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_provinces');
    }
}
