<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvGoodsReceiptInternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_receipt_internal', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('goods_receipt_id')
                ->comment('ID phiếu nhập');

            $table->unsignedInteger('borrow_id')
                ->comment('ID phiếu mượn');

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
        Schema::dropIfExists('inv_goods_issue_sells');
    }
}
