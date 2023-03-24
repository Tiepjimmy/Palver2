<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePermissionGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_store_permission_group', function (Blueprint $table) {
            $table->integer('store_id')->comment('Mã tổ chức');
            $table->integer('permission_group_id')->comment('Mã nhóm quyền');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_store_permission_group` comment 'Nhóm quyền và tổ chức'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_store_permission_group');
    }
}
