<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvGoodsReceiptDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_receipt_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('goods_receipt_id')
                ->comment('ID phiếu nhập');

            $table->unsignedInteger('lot_id')
                ->comment('ID lô');

            $table->unsignedInteger('product_id')
                ->comment('ID sản phẩm');

            $table->unsignedBigInteger('price')
                ->comment('Giá nhập');

            $table->unsignedInteger('quantity')
                ->comment('Số lượng nhập');

            $table->char('storage_location', 255)
                ->nullable()
                ->comment('Vị trí lưu kho');

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
        Schema::dropIfExists('inv_goods_receipt_details');
    }
}
