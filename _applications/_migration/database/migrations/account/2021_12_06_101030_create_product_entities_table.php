<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductEntitiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_entities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('Sản phẩm');
            $table->char('product_entity_cd', 20)->comment('Mã biến thể sản phẩm');
            $table->boolean('is_overwrite_prices')->comment('Có áp dụng giá khác hay không');
            $table->boolean('has_options');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_entities` comment 'Biến thể của sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_entities');
    }
}
