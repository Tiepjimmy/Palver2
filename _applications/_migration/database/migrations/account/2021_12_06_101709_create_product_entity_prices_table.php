<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductEntityPricesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_product_entity_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_entity_id')->comment('ID biến thể');
            $table->integer('user_id')->nullable()->comment('Người thực hiện thêm giá. Null thì sẽ là system');
            $table->float('old_prices', 20)->comment('Giá bán cũ');
            $table->float('old_wholesale_prices', 20)->comment('Giá bán buôn cũ');
            $table->float('old_cost_prices', 20)->comment('Giá vốn cũ');
            $table->float('prices', 20)->comment('Giá sẽ áp dụng');
            $table->float('wholesale_prices', 20)->comment('Giá bán buôn sẽ áp dụng');
            $table->float('cost_prices', 20)->comment('Giá vốn sẽ áp dụng');
            $table->datetime('apply_started_at')->comment('Áp dụng từ ngày');
            $table->datetime('apply_ended_at')->nullable()->comment('Giá áp dụng đến ngày. Nếu null sẽ là mãi mai');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_product_entity_prices` comment 'Lịch sử giá biến thể sản phẩm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_product_entity_prices');
    }
}
