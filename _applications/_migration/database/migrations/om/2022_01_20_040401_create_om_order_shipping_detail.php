<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmOrderShippingDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_shipping_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('order_id')
                ->comment('đơn hàng');
            $table->unsignedInteger('shipping_status_id')
                ->comment('trạng thái vận đơn');
            $table->unsignedInteger('warehouse_id')->nullable()
                ->comment('thông tin kho');
            $table->string('bill_of_lading_code', 125)->nullable()
                ->comment('mã vận đơn');
            $table->unsignedTinyInteger('shipping_type')->nullable()
                ->comment('kiểu vận chuyển: 1. theo đơn vị vận chuyển, 2. theo ship ngoài');
            $table->unsignedInteger('shipping_provider_account_id')->nullable()
                ->comment('tài khoản liên kết api với hãng vận chuyển');
            $table->unsignedInteger('shipping_partner_id')->nullable()
                ->comment('ship thuê ngoài');
            $table->unsignedTinyInteger('shipping_provider_id')->nullable()
                ->comment('hãng vận chuyển: 1. Giao hàng nhanh, 2. Giao hàng tiết kiệm, ..');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('delivering_at')->nullable()
                ->comment('ngày dự kiến chuyển hàng');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_order_shipping_detail');
    }
}
