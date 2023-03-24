<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvGoodsIssueDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_issue_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('goods_issue_id')
                ->comment('ID phiếu xuất');

            $table->unsignedInteger('lot_id')
                ->comment('ID lô xuất');

            $table->unsignedInteger('product_id')
                ->comment('ID Sản phẩm  xuất');

            $table->unsignedInteger('quantity')
                ->comment('Số lượng xuất');

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
        Schema::dropIfExists('inv_goods_issue_details');
    }
}
