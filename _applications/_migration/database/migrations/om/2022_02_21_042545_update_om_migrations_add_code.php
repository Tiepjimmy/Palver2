<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOmMigrationsAddCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_marketing_leads', function (Blueprint $table) {
            $table->string('code', 25)->nullable()
                ->comment('Mã KH');
            $table->text('description')->nullable()
                ->comment('Mô tả');

            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
