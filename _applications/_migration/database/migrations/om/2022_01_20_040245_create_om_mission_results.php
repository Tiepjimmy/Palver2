<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMissionResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_mission_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('name')
                ->comment('kết quả');
            $table->unsignedInteger('lead_status_id')->nullable()
                ->comment('trạng thái tương ứng');

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
            $table->index('lead_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('om_mission_results');
    }
}
