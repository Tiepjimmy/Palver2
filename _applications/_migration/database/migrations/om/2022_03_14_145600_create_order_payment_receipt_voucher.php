<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentReceiptVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_payment_receipt_voucher', function (Blueprint $table) {
            $table->unsignedInteger('order_payment_id')
                ->comment('thanh toán đơn hàng');
            $table->unsignedInteger('receipt_voucher_id')
                ->comment('chứng từ thu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_order_payment_receipt_voucher');
    }
}
