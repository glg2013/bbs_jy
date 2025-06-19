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
        // 添加 phone 列
        DB::statement("ALTER TABLE users ADD COLUMN phone VARCHAR(255) NULL UNIQUE AFTER name");

        // 修改 email 列可为空
        DB::statement("ALTER TABLE users MODIFY email VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 删除 phone 列
        DB::statement("
            ALTER TABLE users
            DROP COLUMN phone
        ");

        // 恢复 email 列为不可空
        DB::statement("
            ALTER TABLE users
            MODIFY email VARCHAR(255) NOT NULL
        ");
    }
};
