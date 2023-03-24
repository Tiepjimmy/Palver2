<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AfterUpdateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('acc_t_warehouses', function (Blueprint $table) {
            $table->string('warehouse_cd', 20)->nullable()->comment('Mã kho');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acc_t_warehouses', function (Blueprint $table) {
            $table->dropColumn('warehouse_cd');
        });
    }
}
