<?php

use App\Models\Post;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 50; $i++) { 
            $newPost = new Post();
            $newPost->title = $faker->realText(35);
            $newPost->author = $faker->userName();
            $newPost->post_date = $faker->dateTimeThisYear();
            $newPost->post_image = $faker->imageUrl();
            $newPost->post_content = $faker->paragraph(5, true);
            $newPost->slug = Str::slug($newPost->title, '-') . '-' . ($i+1);
            $newPost->save();
        }
    }
}
