<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\UserResource
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;

        $users = User::query()->paginate($pageSize);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param mixed $resource
     * @return \App\Http\Resources\UserResource
     */
    public function store(Request $request, UserRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'email',
            'password'
        ]));

        return new UserResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed $resource
     * @param \App\Models\User $user
     * @return \App\Http\Resources\UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Http\Resources\UserResource
     */
    public function update(Request $request,User $user, UserRepository $repository)
    {
        $updated_user = $repository->update($user,$request->only([
            'name',
            'email',
            'password',
        ]));

        return new UserResource($updated_user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, UserRepository $repository)
    {
        $repository->forceDelete($user);        

        return new JsonResponse([
            'data' => 'User deleted successful'
        ]);
    }
}
