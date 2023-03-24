<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmMarketingLeadStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_marketing_lead_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')
                ->comment('chi nhánh');

            $table->string('name')
                ->comment('tên trạng thái');
            $table->string('code', 64)->nullable()
                ->comment('mã trạng thái');
            $table->string('color', 64)->nullable()
                ->comment('màu sắc');
            $table->text('description')->nullable()
                ->comment('mô tả');

            $table->unsignedSmallInteger('level')->nullable()
                ->comment('bộ trạng thái');

            $table->boolean('is_system')->default(0)
                ->comment('trạng thái hệ thống: 1.Có, 0. Không');
            $table->boolean('is_default')->default(0)
                ->comment('trạng thái mặc định: 1.Có, 0. Không');

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
        Schema::dropIfExists('om_marketing_lead_statuses');
    }
}
