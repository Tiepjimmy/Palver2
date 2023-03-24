<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTokensTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_t_user_tokens', function (Blueprint $table) {
            $table->char('jti', 100);
            $table->integer('user_id')->comment('UserID');
            $table->string('expires_at', 20)->comment('Ngày hết hạn của token');
            $table->boolean('is_longtime')->default(false)->comment('Token có lưu dài hạn hay không');
            $table->timestamps();
            $table->softDeletes();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `acc_t_user_tokens` comment 'Tokens user'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acc_t_user_tokens');
    }
}
