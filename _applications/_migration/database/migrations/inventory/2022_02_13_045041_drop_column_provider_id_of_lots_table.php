<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnProviderIdOfLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_lots', function (Blueprint $table) {
            $table->dropColumn('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_lots', function (Blueprint $table) {
            $table->unsignedInteger('provider_id')
                ->comment('ID nhà cung cấp');
        });
    }
}
