<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvRefundsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_refunds_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('refund_id')
                ->comment('ID phiếu hoàn');

            $table->unsignedInteger('lot_id')
                ->comment('ID lô');

            $table->unsignedInteger('product_id')
                ->comment('ID sản phẩm');

            $table->unsignedInteger('quantity')
                ->comment('Số lượng');

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
        Schema::dropIfExists('inv_refunds_details');
    }
}
