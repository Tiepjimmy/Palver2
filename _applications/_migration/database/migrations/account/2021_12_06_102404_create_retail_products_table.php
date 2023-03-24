<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_retail_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->comment('Tổ chức trực thuộc');
            $table->integer('product_id')->comment('ID sản phẩm');
            $table->integer('volume_unit_id')->comment('Đơn vị khối lượng');
            $table->integer('product_catalog_id')->comment('Phân loại sản phẩm');
            $table->char('product_cd', 50)->comment('Mã sản phẩm');
            $table->string('product_name', 255)->comment('Tên thực của sản phẩm');
            $table->string('product_display_name', 255)->comment('Tên hiển thị của sản phẩm');
            $table->float('quantity', 20)->comment('Số lượng sản phẩm');
            $table->string('description', 1024)->nullable()->comment('Mô tả sản phẩm');
            $table->string('product_avatar', 1024)->nullable()->comment('Ảnh chi tiết của sản phẩm');
            $table->enum('is_sales', ['yes','no'])->default('yes')->comment('Trạng thái kinh doanh của sản phẩm');
            $table->enum('is_enable_tax', ['yes','no'])->default('no')->comment('Trạng thái áp dụng thuế của sản phẩm');
            $table->float('tax_percent', 20)->nullable()->comment('Mức thuế áp dụng');
            $table->enum('product_type', ['combo','single'])->comment('Loại sản phẩm đơn hay combo');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_retail_products` comment 'Sản phầm chi nhánh'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_retail_products');
    }
}
