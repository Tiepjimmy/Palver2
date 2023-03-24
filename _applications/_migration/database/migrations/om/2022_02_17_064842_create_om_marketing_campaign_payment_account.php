<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMarketingCampaignPaymentAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_marketing_campaign_payment_account', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('campaign_id')
                ->comment('');
            $table->unsignedInteger('payment_account_id')
                ->comment('tài khoản quảng cáo');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_marketing_campaign_payment_account');
    }
}
