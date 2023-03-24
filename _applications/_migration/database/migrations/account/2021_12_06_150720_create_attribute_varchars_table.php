<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeVarcharsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_attribute_varchar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->comment('ID thuộc tính');
            $table->string('value_display_name', 255)->comment('Giá trị hiển thị của thuộc tính');
            $table->string('value', 255)->comment('Giá trị thực tế của thuộc tính');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_attribute_varchar` comment 'Thuộc tính SP dạng chuỗi'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_attribute_varchar');
    }
}
