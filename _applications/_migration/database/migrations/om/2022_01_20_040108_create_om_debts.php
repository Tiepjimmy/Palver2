<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmDebts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_debts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('customer_id')
                ->comment('khách hàng');
            $table->unsignedInteger('order_id')->nullable()
                ->comment('đơn hàng');
            $table->unsignedInteger('invoice_id')->nullable()
                ->comment('hóa đơn');
            $table->double('amount')->default(0)
                ->comment('tổng tiền');
            $table->string('description', 500)->nullable()
                ->comment('mô tả');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_debts');
    }
}
