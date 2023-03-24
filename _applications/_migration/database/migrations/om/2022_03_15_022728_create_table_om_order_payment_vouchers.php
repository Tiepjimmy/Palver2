<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOmOrderPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_id')->comment('Thanh thoán');
            $table->unsignedInteger('payment_voucher_id')->comment(' chứng từ thanh toán');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_order_payment_vouchers');
    }
}
