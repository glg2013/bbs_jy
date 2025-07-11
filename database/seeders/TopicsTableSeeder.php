<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run()
    {
        Topic::factory()->count(100)->create();
    }
}

