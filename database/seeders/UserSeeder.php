<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(15)
        ->create();
        // User::factory(15)
        // ->has(Article::factory(3)
        //     ->has(Comment::factory(2)))
        // ->has(Category::factory(3))
        // ->create();
    }
}
