<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderPaymentVoucherChangeInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_payment_vouchers', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->nullable()
                ->comment('đơn hàng')
                ->change();

            $table->unsignedInteger('customer_id')->nullable()
                ->comment('khách hàng')
                ->change();

            $table->unsignedInteger('invoice_id')->nullable()
                ->comment('hóa đơn')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
