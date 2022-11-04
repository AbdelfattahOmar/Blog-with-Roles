<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return view('posts.index', ['allPosts' => $posts]);
    }

    public function create()
    {
        if (auth()->user()->role_id != 1) {
            abort(401);
        }
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        if (auth()->user()->role_id != 1) {
            abort(401);
        }
        $post = Post::create(
            array_merge(
                $request->validated(),
                [
                    'user_id'    => auth()->user()->id,
                    'image_path' => $this->storeImage($request)
                ]
            )
        );
        return to_route('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', ['posts' => $post]);
    }

    public function edit(Post $post)
    {

        if (auth()->user()->id != $post->user_id) {
            abort(401);
        }
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {

        if (auth()->user()->id != $post->user_id) {
            abort(401);
        }
        if (request()->hasFile('image')) {
            $post->image_path = $this->storeImage($request);
        }
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return to_route('posts.index');
    }


    public function destroy(Post $post)
    {
        if (auth()->user()->id != $post->user_id) {
            abort(401);
        }
        $post->delete();
        $post->Comments()->delete();
        return to_route('posts.index');
    }

    public function storeImage($request)
    {
        $imageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
        return $request->image->move(public_path('images'), $imageName);
    }
}
