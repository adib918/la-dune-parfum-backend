<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'user';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'email_verified_at' => $this->email_verified_at,
                'mobile_verified_at' => $this->mobile_verified_at,
                'address' => $this->address,

            ],
            'links' => [
                'self' => route('users.show', $this->id),
            ],
        ];
    }
    public function with(Request $request){
        return [
            'status' => 'success',
        ];
    }
    public function withResponse(Request $request, \Illuminate\Http\JsonResponse $response){
        $response->header('Accept', 'application/json');

    }
}
