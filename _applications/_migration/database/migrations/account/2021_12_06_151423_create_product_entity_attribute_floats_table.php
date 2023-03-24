<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductEntityAttributeFloatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_entity_attribute_float', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_entity_id')->comment('ID biến thể sản phẩm');
            $table->integer('attribute_id')->comment('ID thuộc tính');
            $table->float('float_value', 20)->comment('Giá trị đã được gán');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_entity_attribute_float` comment 'Chỉ định thuộc tính sản phẩm dạng số thập phân'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_entity_attribute_float');
    }
}
