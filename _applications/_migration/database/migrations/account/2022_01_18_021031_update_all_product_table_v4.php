<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllProductTableV4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acc_t_retail_products', function (Blueprint $table) {
            $table->integer('product_id')->nullable()->comment('ID sản phẩm')->change();
        });

        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->integer('product_entity_id')->nullable()->comment('ID biến thể sản phẩm')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acc_t_retail_products', function (Blueprint $table) {
            $table->integer('product_id')->comment('ID sản phẩm')->change();
        });

        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->integer('product_entity_id')->comment('ID biến thể sản phẩm')->change();
        });
    }
}
