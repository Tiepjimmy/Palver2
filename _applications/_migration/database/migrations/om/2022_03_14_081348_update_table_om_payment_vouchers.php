<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableOmPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_payment_vouchers', function (Blueprint $table) {

            $table->string('voucher_code',30)->after('store_id')
                ->comment('Mã chứng từ');
                
            $table->enum('type_voucher', ['tien_mat', 'so_phu_ngan_hang'])->after('voucher_code')
                ->comment('Loại chứng từ');

            $table->unsignedInteger('type_payment_voucher_id')->after('type_voucher')->comment('loại chứng từ chi');
            $table->unsignedInteger('customer_group_id')->after('type_payment_voucher_id')
                ->comment('Đối tượng nhận');
          
            $table->dateTime('confirmed_at')->after('customer_group_id')->comment('Ngày ghi nhận');
            $table->boolean('is_business_result')->default(0)->after('confirmed_at')->comment('Hoạch toán kết quả kinh doanh');
            $table->boolean('is_active')->default(1)->after('is_business_result')->comment('Trạng thái');
            $table->text('description')->nullable()->comment('Mô tả');
            $table->dropColumn('order_id');
            $table->dropColumn('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
