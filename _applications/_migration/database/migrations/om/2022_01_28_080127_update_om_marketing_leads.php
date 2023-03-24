<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOmMarketingLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('om_marketing_leads', function (Blueprint $table) {
            $table->unsignedTinyInteger('source_id')->nullable()
                ->comment('nguồn tạo');
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
