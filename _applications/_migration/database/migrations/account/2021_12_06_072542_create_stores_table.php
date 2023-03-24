<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->comment('ID tỉnh thành');
            $table->integer('district_id')->comment('ID quận huyện');
            $table->integer('ward_id')->comment('ID phường xã');
            $table->integer('parent_id')->nullable()->comment('ID Chi nhánh trực thuôc');
            $table->char('tree_path', 255)->nullable()->comment('Cây thư mục ( áp dụng trong tổ chức )');
            $table->string('store_name')->comment('Tên tổ chức');
            $table->char('hotline', 20)->nullable()->comment('SĐT hotline');
            $table->enum('active_status', ['active','inactive'])->default('active')->comment('active status : active, inactive');
            $table->string('address')->nullable()->comment('Địa chỉ chi tiết');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_stores` comment 'Chi nhánh, tổ chức, đơn vị'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_stores');
    }
}
