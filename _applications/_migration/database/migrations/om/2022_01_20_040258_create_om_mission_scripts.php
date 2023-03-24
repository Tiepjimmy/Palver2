<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMissionScripts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_mission_scripts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->unsignedInteger('task_id')
                ->comment('nhiệm vụ');
            $table->unsignedInteger('result_id')
                ->comment('kết quả');
            $table->unsignedInteger('next_task_id')
                ->comment('nhiệm vụ kế tiếp');
            $table->unsignedInteger('next_task_end_at')
                ->comment('thời gian chờ nhiệm vụ kế tiếp, tính theo phút');

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
        Schema::dropIfExists('om_mission_scripts');
    }
}
