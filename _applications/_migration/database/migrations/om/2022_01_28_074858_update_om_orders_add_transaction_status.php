<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOmOrdersAddTransactionStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_orders', function (Blueprint $table) {
            $table->dateTime('update_success_at')->nullable()
                ->comment('thời gian cập nhật thành công');
            $table->unsignedTinyInteger('transaction_status')->nullable()
                ->comment('trạng thái giao dịch');
            $table->unsignedInteger('up_sale_id')->nullable()
                ->comment('người upsale');
            $table->unsignedTinyInteger('price_policy')->nullable()
                ->comment('chính sách giá');
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
