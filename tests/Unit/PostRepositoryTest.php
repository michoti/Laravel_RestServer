<?php

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Repositories\PostRepository;
use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends \Tests\TestCase
{
    public function test_create()
    {
        $repository = $this->app->make(PostRepository::class);

        $payload = [
            'title' => 'heyy',
            'body' => [],            
        ];

        $result = $repository->create($payload);

        $this->assertSame($payload['title'], $result->title, 'Post created does not have the title');
        
    }

    public function test_update()
    {
        // Goal: make sure we can update a post using update()
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()[0];

        $payload = [
            'title' => 'abdtetet',
        ];

        $updated = $repository->update($dummyPost, $payload);
        $this->assertSame($payload['title'], $updated->title, 'post does not have same title as updated');

        
    }

        public function test_delete_will_throw_exception_when_delete_post_that_doesnt_exist()
        {
            // env
            $repository = $this->app->make(PostRepository::class);
            $dummy = Post::factory(1)->make()->first();

            $this->expectException(GeneralJsonException::class);
            $deleted = $repository->forceDelete($dummy);
        }

    public function test_delete()
    {
         $repository = $this->app->make(PostRepository::class);
         $dummy = Post::factory(1)->create()->first();

         $deleted = $repository->forceDelete($dummy);

         $found = Post::find($dummy->id);

         $this->assertSame(null, $found, 'Post was not deleted');

        
    }

}
