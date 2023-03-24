<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acc_t_products', function (Blueprint $table) {
            $table->char('sku', 50)->comment('Mã SKU sản phẩm');
            $table->string('unit', 255)->comment('Đơn vị tính');
        });

        Schema::table('acc_t_product_entities', function (Blueprint $table) {
            $table->char('sku', 50)->comment('Mã SKU sản phẩm');
            $table->string('product_entity_avatar', 1024)->comment('Ảnh chính sản phẩm');
        });

        Schema::table('acc_t_retail_products', function (Blueprint $table) {
            $table->char('sku', 50)->comment('Mã SKU sản phẩm');
            $table->string('unit', 255)->comment('Đơn vị tính');
        });

        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->char('sku', 50)->comment('Mã SKU sản phẩm');
            $table->string('product_entity_avatar', 1024)->comment('Ảnh chính sản phẩm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acc_t_products', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('unit');
        });

        Schema::table('acc_t_product_entities', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('product_entity_avatar');
        });

        Schema::table('acc_t_retail_products', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('unit');
        });

        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('product_entity_avatar');
        });
    }
}
