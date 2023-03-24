<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOmCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_customers', function (Blueprint $table) {
            $table->char('extra_mobile', 20)->nullable()
                ->comment('số điện thoại phụ')->nullable();
            $table->unsignedInteger('country_id')->nullable()
                ->comment('quốc gia');
            $table->unsignedInteger('province_id')->nullable()
                ->comment('tỉnh, khu vực');
            $table->unsignedInteger('district_id')->nullable()
                ->comment('quận, huyện');
            $table->unsignedInteger('ward_id')->nullable()
                ->comment('phường, xã');
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
