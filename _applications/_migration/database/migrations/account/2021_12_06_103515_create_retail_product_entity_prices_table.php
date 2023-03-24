<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailProductEntityPricesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_retail_product_entity_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_entity_id')->comment('ID biến thể sản phẩm');
            $table->integer('user_id')->comment('ID user');
            $table->float('old_prices', 20)->comment('Giá cũ');
            $table->float('old_wholesale_prices', 20)->comment('Giá bán buôn cũ');
            $table->float('old_cost_prices', 20)->comment('Giá vốn cũ');
            $table->float('prices', 20)->comment('Giá mới');
            $table->float('wholesale_prices', 20)->comment('Giá bán buôn mới');
            $table->float('cost_prices', 20)->comment('Giá vốn áp dụng');
            $table->datetime('apply_started_at')->comment('Áp dụng từ ngày');
            $table->datetime('apply_ended_at')->comment('Áp dụng đến ngày. Nếu null sẽ là áp dụng mãi mãi');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_retail_product_entity_prices` comment 'Lịch sử giá biến thể sản phầm chi nhánh'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_retail_product_entity_prices');
    }
}
