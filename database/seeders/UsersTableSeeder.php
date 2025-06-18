<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成数据集合
        User::factory()->count(10)->create();

        // 单独处理第一个用户
        $user = User::find(1);
        $user->name = 'fengniancong';
        $user->email = 'fengniancong@example.com';
        $user->avatar = 'http://larabbs.test/avatar/zovoi0uuifa6.jpg';
        $user->password = bcrypt('123456');
        $user->save();

        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');

        // 再处理一下第二个用户
        $user = User::find(2);
        $user->name = 'honglang';
        $user->email = 'honglang@example.com';
        $user->avatar = 'http://larabbs.test/avatar/dboy.png';
        $user->password = bcrypt('123456');
        $user->save();

        // 将 2 号用户指派为『管理员』
        $user->assignRole('Maintainer');
    }
}
