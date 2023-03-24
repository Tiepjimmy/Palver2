<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllProductTableV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acc_t_products', function (Blueprint $table) {
            $table->integer('minimum_inventory')->comment('Tồn kho tối thiểu');
        });

        Schema::table('acc_t_retail_products', function (Blueprint $table) {
            $table->integer('minimum_inventory')->comment('Tồn kho tối thiểu');
        });

        Schema::table('acc_t_product_entities', function (Blueprint $table) {
            $table->integer('minimum_inventory')->comment('Tồn kho tối thiểu');
        });

        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->integer('minimum_inventory')->comment('Tồn kho tối thiểu');
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
            $table->dropColumn('minimum_inventory');
        });

        Schema::table('acc_t_retail_products', function (Blueprint $table) {
            $table->dropColumn('minimum_inventory');
        });

        Schema::table('acc_t_product_entities', function (Blueprint $table) {
            $table->dropColumn('minimum_inventory');
        });

        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->dropColumn('minimum_inventory');
        });
    }
}
