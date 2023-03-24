<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feature_id')->comment('ID chức năng');
            $table->string('permission_name', 255)->comment('Tên quyền');
            $table->char('permission_cd', 20)->comment('Mã quyền');
            $table->enum('private', ['yes', 'no'])->comment('Chỉ dùng cho đơn vị hay không : yes : dùng riêng cho đơn vị, no : dùng cho toàn bộ hệ thống');
            $table->text('tooltip')->comment('Tooltip : mô tả quyền là gì')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_permissions` comment 'Quyền'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_permissions');
    }
}
