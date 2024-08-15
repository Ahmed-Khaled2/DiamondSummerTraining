<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    public function index()
    {
        return Auth::user()->posts;
    }


    public function store(StorePostRequest $request)
    {

        $post = new Post($request->validated());
        $post->user_id = Auth::id();
        $post->save();
        return $post;
    }

    public function show(Post $post)
    {
        if($post->post_owner_id != Auth::id()){
            abort(403, 'You are not authorized to view this post');
        }
        return $post->load(['user:id,name' , 'comments.user:id,name']);
    }



    public function showUserPosts($userID)
    {
        $post = Post::where('post_owner_id', $userID)->get();
        if($post == null){
            return ["message" => "no posts found for this user"];
        }
        return $post;
    }


    public function update(UpdatePostRequest $request, Post $post)
    {

        $post->update($request->validated());
        return $post;

    }


    public function destroy(Post $post)
    {

        if ($post->post_owner_id != Auth::id()) {
            abort(403, 'You are not authorized to view this post');
        }
        $post->delete();
        return ["message" => "post deleted successfully"];
    }
}
