<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_catalog_id')->comment('Loại sản phẩm');
            $table->integer('volume_unit_id')->comment('Loại đơn vị khối lượng');
            $table->char('product_cd', 50)->comment('Code sản phẩm');
            $table->string('product_name', 255)->comment('Tên thực sản phẩm');
            $table->string('product_display_name', 255)->comment('Tên hiển thị của sản phẩm');
            $table->float('quantity', 20)->comment('Số lượng sản phẩm');
            $table->string('description', 1024)->comment('Mô tả sản phẩm');
            $table->string('product_avatar', 1024)->comment('Ảnh chính sản phẩm');
            $table->enum('is_sales', ['yes','no'])->comment('Sản phẩm có kinh doanh hay không');
            $table->enum('is_enable_tax', ['yes','no'])->comment('Sản phẩm có tính thuế hay không');
            $table->float('tax_percent', 20)->comment('Mức thuế áp dụng : 5%, 10%, 12 % ...');
            $table->enum('product_type', ['combo','single'])->comment('Loại sản phẩm đơn hay combo');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_products` comment 'Chuẩn hóa sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_products');
    }
}
