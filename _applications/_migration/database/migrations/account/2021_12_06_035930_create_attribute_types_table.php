<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_attribute_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attribute_name', 255)->comment('Tên thuộc tính');
            $table->char('attribute_cd', 20)->comment('Mã thuộc tính');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_attribute_type` comment 'Loại thuộc tính'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_attribute_type');
    }
}
