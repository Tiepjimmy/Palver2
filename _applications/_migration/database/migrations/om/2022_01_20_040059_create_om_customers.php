<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');
            $table->unsignedInteger('created_store_id')->nullable()
                ->comment('chi nhánh tạo khách hàng');

            $table->string('name')->comment('họ tên');
            $table->char('mobile', 20)
                ->comment('số điện thoại');
            $table->string('email', 125)->nullable()
                ->comment('email');
            $table->unsignedInteger('customer_group_id')->nullable()
                ->comment('nhóm khách hàng');
            $table->string('code')
                ->comment('mã đơn hàng');
            $table->unsignedTinyInteger('gender')->default(0)
                ->comment('giới tính - 0.chưa xác định, 1.nam, 2.nữ');
            $table->string('facebook')->nullable()
                ->comment('link facebook');
            $table->unsignedInteger('zone_id')->nullable()
                ->comment('');
            $table->string('address')->nullable()
                ->comment('địa chỉ');
            $table->unsignedTinyInteger('type')->nullable()
                ->comment('phân loại - 1. tổ chức, 2.cá nhân');
            $table->unsignedInteger('source_id')->nullable()
                ->comment('nguồn dẫn');
            $table->string('organization_name')->nullable()
                ->comment('tên tổ chức');
            $table->string('organization_information')->nullable()
                ->comment('thông tin tổ chức');
            $table->string('bank_name')->nullable()
                ->comment('tên ngân hàng');
            $table->string('bank_account_name')->nullable()
                ->comment('tài khoản ngân hàng');
            $table->string('bank_account_number')->nullable()
                ->comment('mã tài khoản ngân hàng');
            $table->unsignedInteger('imported_account_id')->nullable()
                ->comment('người thực hiện import');
            $table->string('imported_code')->nullable()
                ->comment('');
            $table->double('total_revenue')->nullable()
                ->comment('tổng tiền đã chi tiêu');
            $table->string('image_url')->nullable()
                ->comment('ảnh đại diện');

            $table->unsignedInteger('assigned_user_id')->nullable()
                ->comment('người phụ trách');
            $table->unsignedInteger('inviter_id')->nullable()
                ->comment('người giới thiệu');
            $table->unsignedInteger('contact_id')->nullable()
                ->comment('người liên hệ');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->date('birth_date')->nullable()
                ->comment('sinh nhật');
            $table->dateTime('imported_at')->nullable()
                ->comment('thời gian import vào');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('code');
            $table->index('customer_group_id');
            $table->index('mobile');
            $table->fullText('name', 'customer_name_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_customers');
    }
}
