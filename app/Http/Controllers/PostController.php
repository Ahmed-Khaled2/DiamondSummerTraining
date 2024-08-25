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
        return Post::get();
    }

    public function store(StorePostRequest $request)
    {

        $post = new Post($request->validated());
        $post->user_id = Auth::id();

        if ($request->hasFile('image')){
        $filename = $request->file('image')->getClientOriginalName();
        $NewFileName = time().'_'.$filename;
        $img_path = $request->file('image')->storeAs('public/post_images', $NewFileName);
        $post->image = $img_path;
        }

        $post->save();
        return $post;
    }

    public function show(Post $post) {
        return $post;
    }


    public function update(UpdatePostRequest $request, Post $post)
    {

        $post->update($request->validated());

        if ($request->hasFile('image')){
            $filename = $request->file('image')->getClientOriginalName();
            $NewFileName = time().'_'.$filename;
            $img_path = $request->file('image')->storeAs('public/post_images', $NewFileName);
            $post->image = $img_path;
        }

        $post->save();
         return $post;
    }


    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();
        return ["message" => "post deleted successfully"];
    }
}
