<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmCustomerNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_customer_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('customer_id')
                ->comment('khách hàng');
            $table->text('content')->nullable()
                ->comment('nội dung ghi chú');
            $table->unsignedTinyInteger('kind')->default(0)
                ->comment('thái độ từ khách hàng');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_customer_notes');
    }
}
