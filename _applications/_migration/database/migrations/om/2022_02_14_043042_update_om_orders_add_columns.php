<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOmOrdersAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_orders', function (Blueprint $table) {
            $table->unsignedInteger('upsale_user_id')->nullable()
                ->comment('người bán upsale');

            $table->enum('discount_type', ['percent', 'cash'])->nullable()->default('cash')
                ->comment('kiểu giảm giá');

            $table->double('surcharge', 23)->nullable()->default(0)
                ->comment('phụ thu');

            $table->double('insurance', 23)->nullable()->default(0)
                ->comment('khai giá');

            $table->unsignedInteger('cancel_reason_id')->nullable()
                ->comment('lý do hủy đơn');
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
