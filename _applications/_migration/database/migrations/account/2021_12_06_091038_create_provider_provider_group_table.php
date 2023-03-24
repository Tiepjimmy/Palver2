<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderProviderGroupTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_provider_provider_group', function (Blueprint $table) {
            $table->integer('provider_id')->comment('Mã nhà cung cấp');
            $table->integer('provider_group_id')->comment('Mã nhóm nhà cung cấp');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_provider_provider_group` comment 'Nhà cung cấp và nhóm nhà cung cấp'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_provider_provider_group');
    }
}
