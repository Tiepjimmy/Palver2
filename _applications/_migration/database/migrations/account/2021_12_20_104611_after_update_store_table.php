<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AfterUpdateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('acc_t_stores', function (Blueprint $table) {
            $table->string('store_cd', 20)->nullable()->comment('Mã chi nhánh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('acc_t_stores', function (Blueprint $table) {
            $table->dropColumn('store_cd');
        });
    }
}
