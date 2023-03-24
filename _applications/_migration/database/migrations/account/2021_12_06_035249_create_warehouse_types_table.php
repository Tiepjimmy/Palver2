<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_m_warehouse_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('warehouse_type_name', 50)->comment('Tên kho');
            $table->char('warehouse_type_cd', 20)->comment('Mã kho nếu có');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_m_warehouse_types` comment 'Loại kho'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_m_warehouse_types');
    }
}
