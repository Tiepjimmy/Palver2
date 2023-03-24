<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusesTable extends Migration
{
    private $tables = [
        'inv_goods_issue_status',
        'inv_goods_receipt_status',
        'inv_provider_return_status',
        'inv_refunds_status'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect($this->tables)->map(function ($tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->text('note')->comment('Ghi chú, lý do')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        collect($this->tables)->map(function ($tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('note');
            });
        });
    }
}
