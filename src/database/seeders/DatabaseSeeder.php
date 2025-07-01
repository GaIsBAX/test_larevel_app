<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::factory()->count(3)->create();

        $tags = Tag::factory()->count(5)->create();

        $users = User::factory()->count(2)->create();


        // Task::factory(50)
        //     ->create([
        //         'user_id' => fn() => $users->random()->id,
        //         'category_id' => fn() => $categories->random()->id,
        //     ])
        //     ->each(function ($task) use ($tags) {
        //         $task->tags()->sync(
        //             $tags->random(rand(1, 3))->pluck('id')
        //         );
        //     });
    }
}
