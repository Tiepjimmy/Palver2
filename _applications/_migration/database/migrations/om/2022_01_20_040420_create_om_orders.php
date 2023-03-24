<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');
            $table->unsignedInteger('created_store_id')->nullable()
                ->comment('chi nhánh tạo khách hàng');

            $table->unsignedInteger('customer_id')
                ->comment('khách hàng');
            $table->unsignedInteger('lead_id')->nullable()
                ->comment('lead - data số');
            $table->string('customer_name')
                ->comment('họ tên khách hàng');
            $table->char('customer_mobile', 20)->default('N/A')
                ->comment('số điện thoại khách hàng');
            $table->string('customer_email')->nullable()
                ->comment('email khách hàng');
            $table->unsignedInteger('customer_group_id')->nullable()
                ->comment('nhóm khách hàng');
            $table->string('code', 64)->nullable()
                ->comment('mã đơn hàng');
            $table->unsignedInteger('order_status_id')->nullable()
                ->comment('trạng thái đơn hàng');
            $table->unsignedInteger('sub_status_id')->nullable()
                ->comment('sub trạng thái đơn hàng');
            $table->unsignedInteger('shipping_status_id')->nullable()
                ->comment('trạng thái vận đơn: 1. Đang thu gom, 2.Hủy đơn, ..');
            $table->unsignedInteger('shipping_address_id')->nullable()
                ->comment('địa chỉ giao hàng');
            $table->unsignedInteger('billing_address_id')->nullable()
                ->comment('địa chỉ thanh toán');
            $table->unsignedInteger('product_catalog_id')->nullable()
                ->comment('loại sản phẩm');
            $table->double('sub_total')->default(0)
                ->comment('tổng tiền hàng');
            $table->double('grand_total')->default(0)
                ->comment('tổng tiền cần thành toán');
            $table->double('discount_amount')->default(0)
                ->comment('tổng tiền chiết khấu');
            $table->double('shipping_amount')->default(0)
                ->comment('tổng tiền phí vận chuyển');
            $table->double('tax_amount')->default(0)
                ->comment('tổng tiền thuế');
            $table->unsignedTinyInteger('type')->nullable()
                ->comment('loại đơn hàng: 1. Sale, 2. Upsale(CSKH)');
            $table->unsignedMediumInteger('source_id')->nullable()
                ->comment('nguồn đơn hàng');
            $table->string('source_name')->nullable()
                ->comment('tên nguồn đơn hàng');
            $table->unsignedInteger('payment_id')->nullable()
                ->comment('thông tin thanh toán');
            $table->unsignedInteger('confirmed_user_id')->nullable()
                ->comment('người xác nhận đơn');
            $table->unsignedInteger('assigned_user_id')->nullable()
                ->comment('người được gán (xử lý đơn)');
            $table->unsignedInteger('delivered_user_id')->nullable()
                ->comment('người giao hàng');
            $table->unsignedInteger('approved_user_id')->nullable()
                ->comment('người duyệt đơn');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('confirmed_at')->nullable()
                ->comment('thời gian xác nhận chốt đơn');
            $table->dateTime('delivered_at')->nullable()
                ->comment('thời gian giao hàng');
            $table->dateTime('approved_at')->nullable()
                ->comment('thời gian duyệt đơn');
            $table->dateTime('printed_at')->nullable()
                ->comment('thời gian đơn được in');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('customer_id');
            $table->index('lead_id');
            $table->index('order_status_id');
            $table->fullText('customer_mobile', 'order_customer_mobile_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_orders');
    }
}
