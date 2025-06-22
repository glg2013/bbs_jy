<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('weixin_openid')->unique()->nullable()->after('password');
            $table->string('weixin_unionid')->unique()->nullable()->after('weixin_openid');
            //$table->string('password')->nullable()->change();
            // 使用原始 SQL 替代 change() 方法
            DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('weixin_openid');
            $table->dropColumn('weixin_unionid');
            //$table->string('password')->nullable(false)->change();

            // 使用原始 SQL 替代 change() 方法
            DB::statement('ALTER TABLE password MODIFY email VARCHAR(255) NOT NULL');
        });
    }
};
