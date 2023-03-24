<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductCatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_store_product_catalog', function (Blueprint $table) {
            $table->integer('store_id')->comment('ID chi nhánh');
            $table->integer('product_catalog_id')->comment('ID phân loại sản phẩm');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_store_product_catalog` comment 'Chi nhánh và phân loại sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_t_store_product_catalog');
    }
}
