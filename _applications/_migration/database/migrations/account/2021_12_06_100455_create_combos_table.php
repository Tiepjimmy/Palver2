<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCombosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_combos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('Sản phẩm');
            $table->integer('related_product_id')->comment('Sản phẩm trong combo');
            $table->integer('quantity')->comment('Số lượng trong combo');
            $table->float('prices', 20)->comment('Giá áp dụng trong combo');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_combos` comment 'Sản phẩm combo'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_combos');
    }
}
