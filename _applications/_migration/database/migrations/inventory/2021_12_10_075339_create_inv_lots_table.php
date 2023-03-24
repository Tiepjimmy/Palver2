<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_lots', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('provider_id')
                ->comment('ID nhà cung cấp');

            $table->char('code', 50)
                ->comment('Mã lô');

            $table->enum('status', ['active','inactive'])
                ->comment('Trạng thái lô');

            $table->date('expired_date')
                ->nullable()
                ->comment('Thời gian hết hạn');

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
        Schema::dropIfExists('inv_lots');
    }
}
