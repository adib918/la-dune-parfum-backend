<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\V1\CommentCollection;
use App\Http\Resources\V1\CommentResource;
use App\Models\Blog;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        return (new CommentCollection($blog->comments))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Blog $blog)
    {
        $comment = Comment::create([
            'slug' => $request->slug,
            'rate' => $request->rate ? $request->rate : null,
            'user_id' => auth()->user()->id,
            'blog_id' => $blog->id,
        ]);

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog, Comment $comment)
    {
        if($blog->comments()->find($comment->id)){
            return (new CommentResource($comment))
            ->response()
            ->setStatusCode(200);
        }else{
            return response()->json(['message' => 'There is no comment with this id in this blog'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Blog $blog, Comment $comment)
    {
        if($blog->comments()->find($comment->id)){
            $comment->update([
                'slug' => $request->slug ? $request->slug : $comment->slug,
                'rate' => $request->rate ? $request->rate : null,
            ]);

            return (new CommentResource($comment))
                ->response()
                ->setStatusCode(200);
        }else{
            return response()->json(['message' => 'There is no comment with this id in this blog'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, Comment $comment)
    {
        if($blog->comments()->find($comment->id)){
            $comment->delete();

            return response()->json(null, 204);
        }else{
            return response()->json(['message' => 'There is no comment with this id in this blog'], 400);
        }
    }
}
