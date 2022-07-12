<?php 

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\Post;


class PostRepository 
{
    public function create(array $attributes)
    {
        
        return DB::transaction(function() use($attributes) {

            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body', 'body'),
            ]);

            $created->users()->sync(data_get($attributes, 'user_ids'));
            
            return $created;
        });
        
    }

    public function update(Post $post, array $attributes)
    {
        return DB::transaction(function () use($post, $attributes) {
            $updated = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body),
            ]);

            if(!$updated)
            {
                throw new \Exception('Failed to update post');
            }

            if($userIds = data_get($attributes, 'user_ids'))
            {
                $post->users()->sync($userIds);
            }

            return $post;
        });
        
    }

    public function forceDelete(Post $post)
    {
        DB::transaction(function() use($post) {
            $deleted = $post->forceDelete();

            if(!$deleted)
            {
                throw new \Exception('Failed to delete post');
            }

            return $deleted;
        });

        
    }
}