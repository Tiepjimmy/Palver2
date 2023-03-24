<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeIntsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_attribute_int', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->comment('ID Thuộc tính');
            $table->string('value_display_name', 255)->comment('Giá trị hiển thị');
            $table->integer('value')->comment('Giá trị thuộc tính');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_attribute_int` comment 'Thuộc tính SP dạng số tự nhiên'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_attribute_int');
    }
}
