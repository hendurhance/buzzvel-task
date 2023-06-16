<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 2 or 3 files for each task
        Task::factory()
            ->count(50)
            ->hasFiles(rand(2, 3))
            ->create();
    }
}
