<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvBorrowDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_borrow_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('borrow_id')
                ->comment('ID phiếu mượn');

            $table->unsignedInteger('product_id')
                ->comment('ID sản phẩm mượn');

            $table->unsignedInteger('quantity')
                ->comment('Số lượng sản phẩm mượn');

            $table->text('note')
                ->nullable()
                ->comment('Ghi chú');

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
        Schema::dropIfExists('inv_borrow_details');
    }
}
