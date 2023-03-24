<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_borrows', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('from_store_id')
                ->comment('ID cửa hàng cho mượn');

            $table->unsignedInteger('to_store_id')
                ->comment('ID cửa hàng mượn');

            $table->unsignedTinyInteger('status')
                ->comment('Trạng thái phiếu');

            $table->char('receiver_by', 50)
                ->nullable()
                ->comment('Người liên hệ');

            $table->char('receiver_contact', 255)
                ->nullable()
                ->comment('Thông tin liên hệ');

            $table->unsignedInteger('created_by')
                ->default(0)
                ->comment('Người tạo');

            $table->unsignedInteger('updated_by')
                ->default(0)
                ->nullable()
                ->comment('Người cập nhật');

            $table->timestamps();
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
        Schema::dropIfExists('inv_borrows');
    }
}
