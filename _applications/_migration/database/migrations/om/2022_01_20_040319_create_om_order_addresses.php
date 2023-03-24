<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmOrderAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('order_id')
                ->comment('đơn hàng');
            $table->unsignedInteger('country_id')->nullable()
                ->comment('quốc gia');
            $table->unsignedInteger('province_id')->nullable()
                ->comment('tỉnh, khu vực');
            $table->unsignedInteger('district_id')->nullable()
                ->comment('quận, huyện');
            $table->unsignedInteger('ward_id')->nullable()
                ->comment('phường, xã');
            $table->string('address', 500)->nullable()
                ->comment('địa chỉ giao hàng');
            $table->char('mobile', 20)->nullable()
                ->comment('số điện thoại người nhận');
            $table->string('email')->nullable()
                ->comment('');

            $table->boolean('is_default')->default(0)
                ->comment('lựa chọn mặc định: 1. Có, 0. Không');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

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
        Schema::dropIfExists('om_order_addresses');
    }
}
