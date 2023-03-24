<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmShippingPartners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_shipping_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('name')
                ->comment('họ tên shipper');
            $table->char('mobile', 20)
                ->comment('số điện thoại');
            $table->string('email')->nullable()
                ->comment('email');
            $table->unsignedTinyInteger('type')->nullable()
                ->comment('loại đối tác: 1. Đối tác cửa hàng, ..');
            $table->string('address')
                ->comment('địa chỉ');
            $table->string('note', 500)
                ->comment('ghi chú');

            $table->unsignedInteger('assigned_user_id')->nullable()
                ->comment('người phụ trách');
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
        Schema::dropIfExists('om_shipping_partners');
    }
}
