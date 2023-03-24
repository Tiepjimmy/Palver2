<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmOrderNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('order_id')
                ->comment('đơn hàng');
            $table->unsignedInteger('customer_id')
                ->comment('khách hàng');
            $table->enum('type', ['order', 'shipping', 'billing', 'cancel'])->nullable()
                ->comment('kiểu ghi chú');
            $table->string('note', 500)
                ->comment('ghi chú đơn hàng');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('order_id');
            $table->index('customer_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_order_notes');
    }
}
