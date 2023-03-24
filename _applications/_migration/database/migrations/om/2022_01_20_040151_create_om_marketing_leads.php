<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMarketingLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_marketing_leads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('customer_id')->nullable()
                ->comment('khách hàng');
            $table->string('name')->default('N/A')
                ->comment('họ tên');
            $table->char('mobile', 20)
                ->comment('số điện thoại');
            $table->string('email')->nullable()
                ->comment('email');
            $table->unsignedTinyInteger('gender')->default(0)
                ->comment('giới tính: 0. Chưa xác định, 1. Nam, 2. Nữ');
            $table->unsignedInteger('lead_status_id')->nullable()
                ->comment('trạng thái lead - data số');
            $table->string('note', 500)->nullable()
                ->comment('ghi chú từ lead');
            $table->unsignedInteger('channel_id')->nullable()
                ->comment('kênh marketing');
            $table->unsignedInteger('sub_channel_id')->nullable()
                ->comment('sub kênh marketing');
            $table->unsignedInteger('product_catalog_id')->nullable()
                ->comment('loại sản phẩm');
            $table->string('url')->nullable()
                ->comment('link url');
            $table->unsignedSmallInteger('type')->default(0)
                ->comment('loại khách hàng: 0. chưa có đơn, 1. đã có đơn');
            $table->unsignedInteger('mission_id')->nullable()
                ->comment('nhiệm vụ');
            $table->unsignedInteger('mission_script_id')->nullable()
                ->comment('kịch bản nhiệm vụ');

            $table->unsignedInteger('marketer_id')->nullable()
                ->comment('nhân viên marketing');
            $table->unsignedInteger('seller_id')->nullable()
                ->comment('nhân viên sale');
            $table->unsignedInteger('assigned_user_id')->nullable()
                ->comment('người phụ trách');
            $table->unsignedInteger('assigned_group_id')->nullable()
                ->comment('nhóm nhân viên được chia');

            $table->boolean('is_duplicated')->default(0)
                ->comment('xác định số trùng: 1. trùng, 0. không trùng');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('assigned_at')->nullable()
                ->comment('thời gian nhận số');
            $table->dateTime('last_supported_at')->nullable()
                ->comment('thời gian trao đổi cuối');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('lead_status_id');
            $table->index('channel_id');
            $table->index('sub_channel_id');
            $table->index('created_by');
            $table->index('assigned_user_id');
            $table->index('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_marketing_leads');
    }
}
