<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_refunds', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('store_id')
                ->comment('ID cửa hàng');

            $table->unsignedInteger('warehouse_id')
                ->comment('ID kho');

            $table->unsignedInteger('order_id')
                ->comment('ID đơn hàng');

            $table->unsignedTinyInteger('status')
                ->comment('Trạng thái phiếu');

            $table->text('note')
                ->nullable()
                ->comment('Ghi chú');

            $table->unsignedInteger('created_by')
                ->comment('Người tạo');

            $table->timestamp('created_at')
                ->nullable()
                ->comment('Thời gian tạo');

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
        Schema::dropIfExists('inv_refunds');
    }
}
