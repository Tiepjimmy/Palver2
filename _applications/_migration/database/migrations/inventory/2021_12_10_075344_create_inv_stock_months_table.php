<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvStockMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_stock_months', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('store_id')
                ->comment('ID cửa hàng');

            $table->unsignedInteger('warehouse_id')
                ->comment('ID kho');

            $table->unsignedInteger('month')
                ->comment('Tháng');

            $table->unsignedInteger('product_id')
                ->comment('ID sản phẩm');

            $table->enum('type', ['sell','place','buy','cancel','return','refund','borrow','loan'])
                ->comment('Loại tồn');

            $table->unsignedInteger('quantity')
                ->comment('Số lượng tồn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_stock_months');
    }
}
