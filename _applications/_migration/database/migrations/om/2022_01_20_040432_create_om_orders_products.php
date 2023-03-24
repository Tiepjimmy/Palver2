<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmOrdersProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_orders_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('order_id')
                ->comment('đơn hàng');
            $table->unsignedInteger('product_id')
                ->comment('sản phẩm');
            $table->string('product_name')
                ->comment('tên sản phẩm');
            $table->string('product_code')->nullable()
                ->comment('mã sản phẩm');
            $table->string('product_sku')->nullable()
                ->comment('mã sku sản phẩm');
            $table->double('product_price')->default(0)
                ->comment('giá sản phẩm');
            $table->double('product_base_price')->default(0)
                ->comment('giá gốc sản phẩm');
            $table->unsignedInteger('product_unit_id')->nullable()
                ->comment('đơn vị của sản phẩm');
            $table->unsignedInteger('quantity')->default(0)
                ->comment('số lượng');
            $table->double('sub_total')->default(0)
                ->comment('tổng tiền chưa tính chiết khấu');
            $table->double('total')->default(0)
                ->comment('tổng tiền');
            $table->double('discount_amount')->default(0)
                ->comment('giảm giá tổng');
            $table->double('discount_item')->default(0)
                ->comment('giảm giá trên sản phẩm');
            $table->enum('discount_type', ['percent', 'cash'])
                ->comment('kiểu giảm giá');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_orders_products');
    }
}
