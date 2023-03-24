<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmPrintedForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_printed_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('title')
                ->comment('tên form');
            $table->unsignedTinyInteger('type')->nullable()
                ->comment('khổ in: 1.A4/A5, 2.A4/A5 (Ngang), ..');
            $table->text('content')
                ->comment('nội dung - mã html');

            $table->boolean('is_default')->default(0)
                ->comment('đặt làm mặc định: 1. Có, 0. Không');
            $table->boolean('is_active')->default(0)
                ->comment('trạng thái hoạt động: 1. Có, 0. Không');

            $table->unsignedInteger('created_by')
                ->comment('người tạo');
            $table->unsignedInteger('updated_by')->nullable()
                ->comment('người sửa');

            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_printed_forms');
    }
}
