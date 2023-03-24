<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_attribute_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attribute_group_name', 255)->comment('Tên nhóm thuộc tính');
            $table->char('attribute_group_cd', 20)->comment('Mã nhóm thuộc tính');
            $table->enum('active_status', ['active','inactive'])->comment('Trạng thái nhóm thuộc tính');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_attribute_groups` comment 'Nhóm thuộc tính'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_attribute_groups');
    }
}
