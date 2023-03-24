<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMarketingPaymentAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_marketing_payment_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('bank_name')
                ->comment('tên ngân hàng');
            $table->unsignedSmallInteger('card_type')->nullable()
                ->comment('loại thẻ');
            $table->string('card_number', 125)->nullable()
                ->comment('số thẻ');
            $table->string('card_owner')->nullable()
                ->comment('chủ sở hữu thẻ');

            $table->boolean('is_active')->default(0)
                ->comment('trạng thái hoạt động: 1. Có, 2. Không');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

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
        Schema::dropIfExists('om_marketing_payment_accounts');
    }
}
