<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_provider_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->comment('Tổ chức');
            $table->string('group_name', 255)->comment('Tên nhà cung cấp');
            $table->char('group_cd', 20)->comment('Mã nhà cung cấp');
            $table->string('note', 1024)->nullable()->comment('Ghi chú cho nhà cunng cấp');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_provider_groups` comment 'Nhóm nhà cung cấp'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_provider_groups');
    }
}
