<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use DB;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(50)->create();
        Tag::factory(8)->create();
        foreach (Post::all() as $post) { // loop through all posts
            $random_tags = Tag::all()->random(rand(2, 5))->pluck('id')->toArray();
            // Insert random post tag
            foreach ($random_tags as $tag) {
                DB::table('post_tags')->insert([
                    'post_id' => $post->id,
                    'tag_id' => Tag::all()->random(1)[0]->id
                ]);
            }
        }
    }
}
