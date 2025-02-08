<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public static $wrap = 'blogs';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'blogs',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'body' => $this->body,
                'attachment' => $this->attachment ? $this->attachment : 'There is no attachment',
                'user' => new UserResource($this->user),
                'comments' => $this->comments()->count()
            ],
            'link' => [
                'slef' => route('blogs.show', $this->id),
            ],
        ];
    }

    public function with(Request $request){
        return [
            'status' => 'success',
        ];
    }

    public function withResponse(Request $request,JsonResponse $response){
        return $response->header('Accept', 'application/json');
    }
}
