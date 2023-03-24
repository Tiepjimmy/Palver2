<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeFloatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_attribute_float', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->comment('ID thuộc tính');
            $table->string('value_display_name', 255)->comment('Tên hiển thị của giá trị thuộc tính');
            $table->float('value', 20)->comment('Giá thị thuộc tính');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_attribute_float` comment 'Thuộc tính SP dạng số thập phân'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_attribute_float');
    }
}
