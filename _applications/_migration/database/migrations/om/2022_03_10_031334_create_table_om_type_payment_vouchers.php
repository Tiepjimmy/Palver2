<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOmTypePaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('om_type_payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_code', 20)->comment('Mã chứng từ chi');
            $table->string('type_name')->comment('Tên Loại chứng từ chi');
            $table->boolean('is_business_result')->default(0)->comment('Hoạch toán kết quả kinh doanh');
            $table->boolean('is_active')->default(1)->comment('Hiệu lực');
            $table->text('note')->nullable()->comment('Mô tả');
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
        Schema::dropIfExists('om_type_payment_vouchers');
    }
}
