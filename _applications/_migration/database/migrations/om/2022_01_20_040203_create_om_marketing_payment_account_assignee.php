<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMarketingPaymentAccountAssignee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_marketing_payment_account_assignee', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('payment_account_id')
                ->comment('tài khoản thẻ');
            $table->unsignedInteger('account_assignee_id')
                ->comment('người quản lý');

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
        Schema::dropIfExists('om_marketing_payment_account_assignee');
    }
}
