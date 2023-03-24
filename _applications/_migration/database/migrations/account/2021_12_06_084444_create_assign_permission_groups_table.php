<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignPermissionGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_assign_permission_group', function (Blueprint $table) {
            $table->integer('assign_id')->comment('ID bổ nhiệm');
            $table->integer('permission_group_id')->comment('ID nhóm quyền');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_assign_permission_group` comment 'Bổ nhiệm với nhóm quyền'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_assign_permission_group');
    }
}
