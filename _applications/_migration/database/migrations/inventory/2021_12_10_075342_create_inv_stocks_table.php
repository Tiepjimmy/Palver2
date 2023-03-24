<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_stocks', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('store_id')
                ->comment('ID cửa hàng');

            $table->unsignedInteger('warehouse_id')
                ->comment('ID kho');

            $table->unsignedInteger('lot_id')
                ->comment('ID lô');

            $table->unsignedInteger('product_id')
                ->comment('ID sản phẩm');

            $table->enum('type', ['sell','place','buy','cancel','return','refund','borrow','loan'])
                ->comment('Loại tồn kho');

            $table->integer('quantity')
                ->comment('Số lượng');

            $table->unsignedInteger('row_version')
                ->comment('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_stocks');
    }
}
