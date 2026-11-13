<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 'title' => $this->title, 'summary' => $this->summary,
            'permalink' => $this->permalink, 'published_at' => $this->published_at?->toISOString(),
            'thumbnail_url' => $this->thumbnail_url,
            'category' => ['id' => $this->category->id, 'name' => $this->category->name],
        ];
    }
}
