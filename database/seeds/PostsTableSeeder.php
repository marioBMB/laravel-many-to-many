<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Post;
use App\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    
    {   
        for ($i = 0; $i < 10; $i++){
            $post = new Post();
            $post->title = $faker->words(7, true);  /* true indica lo unique */
            $post->content = $faker->text();
            $post->slug = Str::of($post->title)->slug("-");
            $post->published = rand(0,1);
            $post->user_id = User::inRandomOrder()->first()->id; // prende uno degli id esistenti a casaccio
            $post->save();
        }
    }
}
