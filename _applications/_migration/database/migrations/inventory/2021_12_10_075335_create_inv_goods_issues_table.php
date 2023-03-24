<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvGoodsIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_issues', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('store_id')
                ->comment('ID cửa hàng');

            $table->unsignedInteger('warehouse_id')
                ->comment('ID kho');

            $table->char('code', 20)
                ->nullable()
                ->comment('Mã phiếu xuất');

            $table->enum('type', ['sell','internal','cancel','balance'])
                ->comment('Loại phiếu xuất');

            $table->unsignedTinyInteger('status')
                ->comment('Trạng thái phiếu');

            $table->text('note')
                ->nullable()
                ->comment('Ghi chú');

            $table->unsignedInteger('created_by')
                ->comment('Người tạo');

            $table->unsignedInteger('updated_by')
                ->default(0)
                ->nullable()
                ->comment('Người cập nhật');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_goods_issues');
    }
}
