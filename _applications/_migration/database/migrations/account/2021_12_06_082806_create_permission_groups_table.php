<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_permission_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subsystem_id')->comment('Mã phân hệ');
            $table->string('group_name', 255)->comment('Tên nhóm quyền');
            $table->enum('active_status', ['active','inactive'])->comment('Trạng thái nhóm quyền');
            $table->enum('group_type', ['single','full'])->comment('Nhóm quyền cho phép dùng trong toàn bộ hệ thống hay không');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_permission_groups` comment 'Nhóm quyền'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_permission_groups');
    }
}
