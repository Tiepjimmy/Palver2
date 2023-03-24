<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGalleriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('Sản phẩm');
            $table->string('product_image_url', 512)->comment('Link ảnh bộ sưu tập của sản phẩm');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_gallery` comment 'BỘ sưu tập ảnh của sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_gallery');
    }
}
