<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCatalogAttributeGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_catalog_attribute_group', function (Blueprint $table) {
            $table->integer('product_catalog_id')->comment('ID Phân Loại sản phẩm');
            $table->integer('attribute_group_id')->comment('ID Nhóm thuộc tính sản phẩm');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_catalog_attribute_group` comment 'Thuộc tính và phân loại sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_catalog_attribute_group');
    }
}
