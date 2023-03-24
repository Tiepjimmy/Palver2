<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReceiptVoucherAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_receipt_vouchers', function (Blueprint $table) {
            $table->text('description')->nullable()->after('note')
                ->comment('mô tả');
            $table->string('code', 25)->after('id')
                ->comment('mã chứng từ thu');
            $table->boolean('is_active')->default(0)->after('description')
                ->comment('trạng thái hoạt động: 1. Có, 0. Không');
            $table->unsignedInteger('type_collect_voucher_id')->after('is_active')
                ->comment('loại chứng từ thu');
            $table->string('type_object', 25)->after('type_collect_voucher_id')
                ->comment('loại đối tượng');
            $table->enum('type_voucher', ['tien_mat', 'so_phu_ngan_hang'])->after('type_object')
                ->comment('loại chứng từ: tien_mat - tiền mặt, so_phu_ngan_hang - sổ phụ ngân hàng');
            $table->dateTime('confirmed_at')->after('note')->nullable();
            $table->date('created_date')->after('confirmed_at');
            $table->date('updated_date')->after('created_date')->nullable();

            $table->dropColumn('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('om_receipt_vouchers', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('code');
            $table->dropColumn('is_active');
            $table->dropColumn('type_voucher_id');
            $table->dropColumn('type_collect_voucher_id');
            $table->dropColumn('confirmed_at');
            $table->dropColumn('type_voucher');

            $table->unsignedInteger('order_id')
                ->comment('đơn hàng');
        });
    }
}
