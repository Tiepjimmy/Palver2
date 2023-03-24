<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvStockTakeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_stock_take_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('stock_take_id')
                ->comment('ID phiếu kiểm kho');

            $table->unsignedInteger('lot_id')
                ->comment('ID lô');

            $table->unsignedInteger('product_id')
                ->comment('ID sản phẩm');

            $table->unsignedInteger('quantity_before')
                ->comment('Số lượng SP trước kiểm');

            $table->unsignedInteger('quantity_after')
                ->comment('Số lượng SP sau kiểm');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_stock_take_details');
    }
}
