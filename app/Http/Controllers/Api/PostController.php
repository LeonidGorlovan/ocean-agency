<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateCommentRequest;
use App\Models\Post;

class PostController
{
    public function index()
    {
        return Post::query()
            ->paginate();
    }

    public function view(Post $post)
    {
        return $post;
    }

    public function createComment(Post $post, CreateCommentRequest $request)
    {
        return $post->comments()->create([
            'content' => $request->content,
        ]);
    }
}
