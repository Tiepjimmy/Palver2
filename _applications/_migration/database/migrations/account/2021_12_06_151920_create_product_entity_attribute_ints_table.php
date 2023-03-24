<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductEntityAttributeIntsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_entity_attribute_int', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_entity_id')->comment('ID biến thể');
            $table->integer('attribute_id')->comment('ID thuộc tính');
            $table->integer('int_value')->comment('Giá trị được chỉ định');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_entity_attribute_int` comment 'Chỉ định thuộc tính sản phẩm dạng số tự nhiên'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_entity_attribute_int');
    }
}
