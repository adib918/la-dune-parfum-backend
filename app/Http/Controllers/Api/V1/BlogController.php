<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\V1\BlogCollection;
use App\Http\Resources\V1\BlogResource;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return (new BlogCollection(Blog::all()))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $blog = Blog::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);

        if($request->file('attachment')){
            $content = file_get_contents($request->file('attachment'));
            $ext = $request->file('attachment')->extension();
            $file_name = Str::random(25);
            $path = "blogs/$file_name.$ext";
            Storage::disk('public')->put($path, $content);
            $blog->update([
                'attachment' => $path,
            ]);
        }

        return (new BlogResource($blog))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return (new BlogResource($blog))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update([
            'title' => $request->title ? $request->title : $blog->title,
            'body' => $request->body ? $request->body : $blog->body,
        ]);

        if($request->file('attachment')){
            $content = file_get_contents($request->file('attachment'));
            $ext = $request->file('attachment')->extension();
            $file_name = Str::random(25);
            $path = "blogs/$file_name.$ext";
            if($blog->attachment){
                $old_attachment = $blog->attachment;
                Storage::disk('public')->delete($old_attachment);
            }
            Storage::disk('public')->put($path, $content);
            $blog->update([
                'attachment' => $path,
            ]);
        }

        return (new BlogResource($blog))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if($blog->attachment){
            Storage::disk('public')->delete($blog->attachment);
        }
        $blog->delete();

        return response()->json(null, 204);
    }

    public function destroy_attachment(Blog $blog){
        if($blog->attachment){
            Storage::disk('public')->delete($blog->attachment);
            $blog->update(['attachment' => null]);
            return response()->json([
                'message' => 'Attachment successfully deleted!',
            ], 200);
        }else{
            return response()->json([
                'message' => "This blog doesn't have attachment already!",
            ], 400);
        }
    }
}
