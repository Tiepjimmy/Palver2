<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvProviderReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_provider_return_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('provider_return_id')
                ->comment('ID phiếu trả ncc');

            $table->unsignedInteger('lot_id')
                ->comment('ID lô');

            $table->unsignedInteger('product_id')
                ->comment('ID sản phẩm');

            $table->unsignedTinyInteger('quantity')
                ->comment('Số lượng');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_provider_return_details');
    }
}
