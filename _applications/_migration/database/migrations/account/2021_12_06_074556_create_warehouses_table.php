<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_type_id')->comment('Loại kho');
            $table->integer('province_id')->comment('Tỉnh thành');
            $table->integer('district_id')->comment('Quận huyện');
            $table->integer('ward_id')->comment('Phường xã');
            $table->string('warehouse_name')->comment('Tên kho');
            $table->string('note')->nullable()->comment('Ghi chú của kho');
            $table->string('address')->nullable()->comment('Địa chỉ chi tiết');
            $table->char('hotline', 20)->nullable()->comment('SĐT hotline');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_warehouses` comment 'Kho'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_warehouses');
    }
}
