<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTitlesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_job_titles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->comment('Mã tổ chức');
            $table->string('job_title_name')->comment('Tên chức danh');
            $table->enum('job_title_type', ['manager','staff','other'])->default('staff')->comment('Loại chức danh');
            $table->enum('active_status', ['active','inactive'])->default('active')->comment('Trạng thái');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_job_titles` comment 'Chức danh'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_job_titles');
    }
}
