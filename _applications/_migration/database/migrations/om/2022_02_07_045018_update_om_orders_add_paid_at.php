<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOmOrdersAddPaidAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_orders', function (Blueprint $table) {
            $table->dateTime('paid_at')->nullable()->after('update_success_at')
                ->comment('ngày thanh toán');

            $table->index('paid_at');
            $table->index('update_success_at');
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
