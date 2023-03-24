<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvGoodsReceiptStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_receipt_status', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('goods_receipt_id')
                ->comment('ID phiếu nhập');

            $table->unsignedInteger('status')
                ->default(0)
                ->comment('Trạng thái phiếu');

            $table->unsignedInteger('user_id')
                ->comment('Người chuyển trạng thái');

            $table->date('created_date')
                ->comment('Ngày tháng chuyển trạng thái');

            $table->timestamp('created_at')
                ->comment('Giờ chuyển trạng thái');

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
        Schema::dropIfExists('inv_borrows');
    }
}
