<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvGoodsIssueSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_issue_sells', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('goods_issue_id')
                ->comment('ID phiếu xuất');

            $table->unsignedInteger('order_id')
                ->comment('ID đơn hàng');

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
