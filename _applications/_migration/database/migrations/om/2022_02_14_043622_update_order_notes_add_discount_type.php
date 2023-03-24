<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderNotesAddDiscountType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_order_notes', function (Blueprint $table) {
            $table->unsignedInteger('type')->nullable()->default(1)
                ->comment('kiểu ghi chú: 1. đơn hàng, 2. giao hàng, 3. thanh toán, 4. hủy đơn, 5. khuyến mãi')
                ->change();
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
