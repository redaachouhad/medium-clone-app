<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Reda Achouhad',
            'username' => 'reda-achouhad',
            'email' => 'reda@gmail.com'
        ]);

        // Creation of Categories
        $categories = [
            'Technology',
            'Health',
            'Education',
            'Travel',
            'Food',
            'Sports',
            'Science',
        ];

        // generating categories in the database.
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // generate 100 posts in the database.
        // Post::factory(100)->create();

        // calling post seeder
        // $this->call([
        //     PostSeeder::class,
        // ]);

    }
}
