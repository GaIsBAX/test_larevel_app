<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Создаём 3 категории
        $categories = \App\Models\Category::factory()->count(3)->create();
        
        // Создаём 5 тегов
        $tags = \App\Models\Tag::factory()->count(5)->create();
        
        // Создаём 2 пользователей
        $users = \App\Models\User::factory()->count(2)->create();
        
        // Создаём задачи
        \App\Models\Task::factory(50)
        ->create([
            'user_id' => fn() => $users->random()->id,
            'category_id' => fn() => $categories->random()->id,
        ])
        ->each(function ($task) use ($tags) {
            $task->tags()->sync(
                $tags->random(rand(1, 3))->pluck('id')
            );
        });
    }
}

