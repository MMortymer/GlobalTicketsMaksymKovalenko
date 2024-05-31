<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'urlId' => $this->id,
            'userId' => $this->user_id,
            'originalUrl' => $this->original_url,
            'shortenedUrl' => $this->shortened_url
        ];
    }
}
