<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;

class PostSeeder extends Seeder
{
    use TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate('posts');
        $posts = Post::factory(3)
        // ->has(Comment::factory(3), 'comments')
        // ->state([
        //     'title' => 'some title'
        // ])
        // ->untitled()
        ->create();

        $posts->each(function (Post $post)
        {
            $post->users()->sync([FactoryHelper::getRandomModelId(User::class)]);
            
        });

        $this->enableForeignKeyChecks();
    }
}
