<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllProductTableV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acc_t_product_entities', function (Blueprint $table) {
            $table->boolean('is_show')->comment('Hiển thị ở chi nhánh');
        });

        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->integer('product_id')->comment('ID sản phẩm chi nhánh');
            $table->boolean('is_show')->comment('Hiển thị ở chi nhánh');
        });

        Schema::create('acc_t_retail_combos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('Sản phẩm');
            $table->integer('related_product_id')->comment('Sản phẩm trong combo');
            $table->integer('quantity')->comment('Số lượng trong combo');
            $table->float('prices', 20)->comment('Giá áp dụng trong combo');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_retail_combos` comment 'Sản phẩm combo chi nhánh'");

        Schema::create('acc_t_retail_product_gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('Sản phẩm');
            $table->string('product_image_url', 512)->comment('Link ảnh bộ sưu tập của sản phẩm');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_retail_product_gallery` comment 'BỘ sưu tập ảnh của sản phẩm chi nhánh'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acc_t_product_entities', function (Blueprint $table) {
            $table->dropColumn('is_show');
        });
        Schema::table('acc_t_retail_product_entities', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->dropColumn('is_show');
        });
        Schema::drop('acc_t_retail_combos');
        Schema::drop('acc_t_retail_product_gallery');
    }
}
