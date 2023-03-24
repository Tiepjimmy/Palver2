<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmCustomerAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_customer_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('customer_id')
                ->comment('khách hàng');
            $table->char('mobile', 20)
                ->comment('số điện thoại');
            $table->string('email', 125)->nullable()
                ->comment('email');
            $table->unsignedInteger('country_id')->nullable()
                ->comment('quốc gia');
            $table->unsignedInteger('province_id')->nullable()
                ->comment('tỉnh, khu vực');
            $table->unsignedInteger('district_id')->nullable()
                ->comment('quận, huyện');
            $table->unsignedInteger('ward_id')->nullable()
                ->comment('phường xã');
            $table->string('address', 500)->nullable()
                ->comment('địa chỉ giao hàng');

            $table->boolean('is_default')->default(0)
                ->comment('đặt làm mặc định: 1. Có, 0. Không');

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
        Schema::dropIfExists('om_customer_addresses');
    }
}
