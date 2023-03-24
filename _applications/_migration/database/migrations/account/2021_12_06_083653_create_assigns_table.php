<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_assigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->comment('ID tổ chức');
            $table->integer('user_id')->comment('User Id');
            $table->integer('job_title_id')->comment('ID chức danh');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_assigns` comment 'Bổ nhiệm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_assigns');
    }
}
