<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeCollectVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_type_collect_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_code', 25)
                ->comment('mã loại chứng từ thu');
            $table->string('type_name')
                ->comment('tên loại chứng từ thu');
            $table->boolean('is_active')->default(0)
                ->comment('trạng thái hoạt động: 1. Có, 0. Không');
            $table->boolean('is_business_result')->default(0)
                ->comment('hạch toán kết quả kinh doanh: 1. Có, 0. Không');
            $table->text('note')->nullable()
                ->comment('mô tả');

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
        Schema::dropIfExists('om_type_collect_vouchers');
    }
}
