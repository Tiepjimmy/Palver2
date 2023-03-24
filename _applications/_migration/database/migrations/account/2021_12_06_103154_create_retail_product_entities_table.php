<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailProductEntitiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->comment('ID chi nhánh');
            $table->integer('product_entity_id')->comment('ID biến thể sản phẩm');
            $table->boolean('is_overwrite_prices')->default(false)->comment('Có ghi đè giá hay không');
            $table->boolean('has_options')->default(false)->comment('Sản phẩm có nhiều biến thể hay không');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_retail_product_entities` comment 'Biến thể sản phầm chi nhánh'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_retail_product_entities');
    }
}
