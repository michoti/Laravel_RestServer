<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use App\Rules\IntegerArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


/**
 * 
 * 
 * @group Posts Management
 * APIs to manage the Posts Resource
 * 
 * 
 */


class PostController extends Controller
{

    /**
     * 
     * Display a list of posts
     * 
     * @queryParam page_size int size per page. Default is '20'. Example 20.
     * @queryParam ?page= int page to view. Example 1.
     */

    public function index(Request $request)
    {
        // throw new GeneralJsonException('error#index', 422);
        
        $pageSize = $request->page_size ?? 20;

        $posts = Post::query()->paginate($pageSize);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \App\Http\Resources\PostResource
     */
    public function store(Request $request, PostRepository $repository)
    {
        $payload = $request->only([
            'title',
            'body',
            'user_ids'
        ]);

        $validator = Validator::make($payload,[
            'title'                  => 'required|string|min:5',
            'body'                   => 'nullable|string|required',
            'user_ids' => [
                'array',
                'required',
                 new IntegerArray(),
            ],[
                'body.required'      => 'please enter a body value',
                'title.string'       => 'title needs to be a string',
            ],
            [
                'user_ids'           => 'USsssER ID'
            ]
        ]);

        $validator->validate();

        $created = $repository->create($payload);

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\PostResource
     */
    public function update(Request $request, Post $post, PostRepository $repository)
    {
        $post = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids'
        ]));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, PostRepository $repository)
    {
        $post = $repository->forceDelete($post);

        return new JsonResponse([
            'data' => 'delete successful'
        ]);


    }
}
