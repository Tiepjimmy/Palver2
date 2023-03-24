<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMarketingCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_marketing_campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('title')
                ->comment('tên chiến dịch');
            $table->string('advertisement_id')->nullable()
                ->comment('id quảng cáo');
            $table->unsignedInteger('channel_id')->nullable()
                ->comment('kênh');
            $table->unsignedInteger('sub_channel_id')->nullable()
                ->comment('sub kênh');
            $table->unsignedInteger('product_catalog_id')->nullable()
                ->comment('loại sản phẩm');
            $table->string('link_token')->nullable()
                ->comment('link token');
            $table->unsignedInteger('payment_account_id')->nullable()
                ->comment('tài khoản tiền marketing');
            $table->double('estimated_amount')->default(0)
                ->comment('kinh phí dự trù');
            $table->double('estimated_data')->default(0)
                ->comment('data số dự trù');
            $table->double('estimated_revenue')->default(0)
                ->comment('doanh thu dự trù');
            $table->double('actual_amount')->default(0)
                ->comment('kinh phí thực tế');
            $table->double('actual_data')->default(0)
                ->comment('data số thực tế');
            $table->double('actual_revenue')->default(0)
                ->comment('doanh thu thực tế');
            $table->string('reference_source')->nullable()
                ->comment('tham chiếu (ảnh, văn bản, ..)');

            $table->boolean('is_active')->default(0)
                ->comment('trạng thái hoạt động: 1. Có, 0. Không');

            $table->unsignedInteger('assigned_user_id')->nullable()
                ->comment('người phụ trách');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('start_at')->nullable()
                ->comment('thời gian bắt đầu chạy chiến dịch');
            $table->dateTime('end_at')->nullable()
                ->comment('thời gian kết thúc chiến dịch');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('channel_id');
            $table->index('sub_channel_id');
            $table->index('start_at');
            $table->index('end_at');
            $table->index(['start_at', 'end_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_marketing_campaigns');
    }
}
