<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public static $wrap = 'comments';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'comments',
            'id' => $this->id,
            'attributes' => [
                'slug' => $this->slug,
                'rate' => $this->rate ? $this->rate : "This comment doesn't contain rate",
                'user' => new UserResource($this->user),
                'blog' => new BlogResource($this->blog),
            ],
            'links' => [
                'self' => route('blogs.comments.show', ['blog' => $this->blog->id, 'comment' => $this->id]),
            ],
        ];
    }

    public function with(Request $request){
        return [
            'status' => 'success',
        ];
    }

    public function withResponse(Request $request, JsonResponse $response){
        return $response->header('Accept', 'application/json');
    }
}
