<?php 

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use Illuminate\Support\Facades\DB;
use App\Models\Post;


class PostRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        
        return DB::transaction(function() use($attributes) {

            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body', 'body'),
            ]);

            throw_if(!$created, GeneralJsonException::class, 'Post creation unsuccessful', 422);

            $created->users()->sync(data_get($attributes, 'user_ids'));
            
            return $created;
        });
        
    }

    public function update($post, array $attributes)
    {
        return DB::transaction(function () use($post, $attributes) {
            $updated = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Post not updated!', 422);

            if($userIds = data_get($attributes, 'user_ids'))
            {
                $post->users()->sync($userIds);
            }

            return $post;
        });
        
    }

    public function forceDelete($post)
    {
        DB::transaction(function() use($post) {
            $deleted = $post->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, 'Post NOT deleted!', 422);

            return $deleted;
        });

        
    }
    
}






/**
 * Exception helper functions
 * 
 * report(Exception::class)
 * abort()
 * 
 */