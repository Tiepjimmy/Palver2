<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmShippingProviderAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_shipping_provider_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('account_name')
                ->comment('tên tài khoản');
            $table->string('verify_id', 125)
                ->comment('id xác thực api vận chuyển');
            $table->binary('verify_secret')
                ->comment('mã xác thực api vận chuyển');
            $table->text('options')
                ->comment('lựa chọn cấu hình');
            $table->string('shop_name')->nullable()
                ->comment('tên chi nhánh');
            $table->string('prefix')->nullable()
                ->comment('tiền tố mã vạch');
            $table->unsignedInteger('shipping_provider_id')->nullable()
                ->comment('hãng vận chuyển');

            $table->boolean('is_default')->default(0)
                ->comment('đặt làm mặc định: 1. Có, 0. Không');
            $table->boolean('is_active')->default(0)
                ->comment('trạng thái hoạt động: 1. Có, 2. Không');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

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
        Schema::dropIfExists('om_shipping_provider_accounts');
    }
}
