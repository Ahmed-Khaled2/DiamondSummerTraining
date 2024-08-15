<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;

class CommentController extends Controller
{

    public function index($id)
    {
        $post = Post::find($id);
        if (!$post){
            return response()->json('Post Not Found!');
        }
        return Post::find($id)->comments;
    }

    public function store(StoreCommentRequest $request, $id)
    {
        $post = Post::find($id);
        if (!$post){
            return response()->json('Post Not Found!');
        }

        $comment = new Comment($request->validated());
        $comment->user_id = auth::id();

        return $post->comments()->save($comment);
    }

    public function update(UpdateCommentRequest $request, $postID, $commentID)
    {

        $Post = Post::find($postID);
        if (!$Post){
            return response()->json('Post Not Found!');
        }
        else {
            $comment = Post::find($postID)->comments->find($commentID);
        }

        if (!$comment){
            return response()->json('Comment Not Found!');
        }
        else if ($comment->user_id != Auth::id()){
            return response()->json('This is not your comment!');
        }

        $comment->update($request->validated());

        return $comment;
    }

    public function destroy($postID, $commentID)
    {

        $Post = Post::find($postID);
        if (!$Post){
            return response()->json('Post Not Found!');
        }
        else {
            $comment = Post::find($postID)->comments->find($commentID);
        }

        if (!$comment){
            return response()->json('Comment Not Found!');
        }
        else if ($comment->user_id != Auth::id()){
            return response()->json('This is not your comment!');
        }

        $comment->delete();
        return response()->json('Comment deleted!');
    }
}
