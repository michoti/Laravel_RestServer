<?php

namespace Database\Seeders;

use App\Models\Post;
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
        Post::factory(3)
        // ->state([
        //     'title' => 'some title'
        // ])
        // ->untitled()
        ->create();
        $this->enableForeignKeyChecks();
    }
}
