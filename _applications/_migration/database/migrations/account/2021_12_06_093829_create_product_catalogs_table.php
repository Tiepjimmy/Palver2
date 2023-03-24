<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCatalogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->comment('Danh mục cha');
            $table->char('product_catalog_cd', 20)->nullable()->comment('Mã Danh mục');
            $table->string('product_catalog_name', 255)->nullable()->comment('Tên danh mục');
            $table->string('note', 1024)->nullable()->comment('Ghi chú cho danh mục');
            $table->char('product_cd_prefix', 20)->nullable()->comment('Tiền tố mã sản phẩm');
            $table->enum('active_status', ['active','inactive'])->default('active')->comment('Trạng thái sử dụng');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_catalogs` comment 'Phân loại sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_catalogs');
    }
}
