<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableOrderPaymentColumnConfirmedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_order_payments', function (Blueprint $table) {
            $table->dateTime('confirmed_at')->after('confirmed_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('om_order_payments', function (Blueprint $table) {
            $table->dropColumn('confirmed_at');
        });
    }
}
