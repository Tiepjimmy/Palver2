<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmOrderInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('order_id')
                ->comment('đơn hàng');
            $table->unsignedInteger('customer_id')
                ->comment('khách hàng');
            $table->string('code')
                ->comment('mã hóa đơn');
            $table->double('sub_total')->default(0)
                ->comment('tổng tiền');
            $table->double('grand_total')->default(0)
                ->comment('tổng tiền phải thanh toán');
            $table->double('discount_amount')->default(0)
                ->comment('tổng tiền chiết khấu');
            $table->double('shipping_amount')->default(0)
                ->comment('tổng tiền phí vận chuyển');
            $table->double('tax_amount')->default(0)
                ->comment('tổng tiền thuế');
            $table->double('total_received')->default(0)
                ->comment('tổng tiền đã nhận');
            $table->double('total_returned')->default(0)
                ->comment('tổng tiền trả lại');
            $table->string('note', 500)->nullable()
                ->comment('ghi chú');

            $table->boolean('is_checked')->default(0)
                ->comment('đã xử lý hay chưa: 1. Có, 0. Không');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('order_id');
            $table->index('customer_id');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_order_invoice');
    }
}
