<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableOrderPaymentMethodColumnTypeVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_payment_methods', function (Blueprint $table) {
            $table->enum('type_voucher', ['tien_mat', 'so_phu_ngan_hang'])->after('information')
                ->comment('loại chứng từ: tien_mat - tiền mặt, so_phu_ngan_hang - sổ phụ ngân hàng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('om_payment_methods', function (Blueprint $table) {
            $table->dropColumn('type_voucher');
        });
    }
}
