<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create($postId)
    {
        $post = Post::findOrFail($postId);
        Comment::create([
            'body' => request()->comment,
            'user_id' => auth()->user()->id,
            'post_id' => $postId,

        ]);
        return redirect('posts/' . $postId);
    }

    public function edit($postId, $commentId)
    {
        $post = Post::findOrFail($postId);
        $comment = Comment::where('id', $commentId)->first();
        if (auth()->user()->id != $comment->user_id) {
            abort(401);
        }
        return view('comments.edit', ['post' => $post, 'comment' => $comment]);
    }

    public function update($postId, $commentId)
    {

        $comment = Comment::where('id', $commentId)->first();
        if (auth()->user()->id != $comment->user_id) {
            abort(401);
        }
        $comment->update([
            'body' => request()->comment
        ]);
        return redirect('posts/' . $postId);
    }

    public function delete($postId, $commentId)
    {
        $comment = Comment::where('id', $commentId)->first();
        if (auth()->user()->id != $comment->user_id) {
            abort(401);
        }
        $comment->delete();
        return redirect('posts/' . $postId);
    }
}
