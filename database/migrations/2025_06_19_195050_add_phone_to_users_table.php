<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('phone')->nullable()->unique()->after('password');

            // 使用原始 SQL 替代 change() 方法
            DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NULL');
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
            // 删除 phone 列
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropUnique(['phone']);
                $table->dropColumn('phone');
            }

            // 处理 email 约束
            $table->dropUnique(['email']);

            DB::table('users')->whereNull('email')
                ->update(['email' => DB::raw("CONCAT('temp_', UUID(), '@example.com')")]);

            DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NOT NULL');

            $table->unique(['email']);
        });
    }
};
