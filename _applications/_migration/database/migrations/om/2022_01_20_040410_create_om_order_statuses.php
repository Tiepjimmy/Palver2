<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmOrderStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('name')
                ->comment('tên trạng thái');
            $table->string('code', 64)->nullable()
                ->comment('mã trạng thái');
            $table->string('color', 64)->nullable()
                ->comment('màu sắc');
            $table->string('description', 500)->nullable()
                ->comment('mô tả');
            $table->unsignedTinyInteger('level')->nullable()
                ->comment('nhóm trạng thái: 1. Level 1, 2. Level 2, ..');
            $table->unsignedTinyInteger('type')->nullable()
                ->comment('phân loại: 1.Đơn hàng có sẵn, 2.Đơn hàng đặt trước, 3.Đơn hàng hoàn');
            $table->string('action_name')->nullable()
                ->comment('chức năng gắn với trạng thái');

            $table->boolean('is_no_revenue')->default(0)
                ->comment('không tính doanh thu: 1. Có, 0. Không');
            $table->boolean('is_system')->default(0)
                ->comment('trạng thái hệ thống: 1. Có, 0. Không');
            $table->boolean('is_active')->default(0)
                ->comment('trạng thái hoạt động: 1. Có, 0. Không');

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
        Schema::dropIfExists('om_order_statuses');
    }
}
