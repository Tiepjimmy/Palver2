<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_type_id')->comment('ID phân loại thuộc tính');
            $table->integer('attribute_group_id')->comment('ID nhóm thuốc thính');
            $table->boolean('is_default')->comment('Là thuộc tính mặc định');
            $table->string('attribute_display_name', 255)->comment('Tên hiển thị của thuộc tính');
            $table->char('attribute_cd', 20)->comment('Mã thuộc tính');
            $table->boolean('is_require')->comment('Bắt buộc nhập hay không');
            $table->enum('active_status', ['active','inactive'])->comment('Trạng thái sử dụng của thuộc tính');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_attributes` comment 'Thuộc tính sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_attributes');
    }
}
