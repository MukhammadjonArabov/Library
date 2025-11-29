<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'isbn'             => $this->isbn,
            'published_year'   => $this->published_year,
            'total_copies'     => $this->total_copies,
            'available_copies' => $this->available_copies,
            'is_available'     => $this->available_copies > 0,
            'borrow_count'     => $this->whenLoaded('borrowings', fn() => $this->borrowings->count()),

            'author' => [
                'id'        => $this->whenLoaded('author', fn() => $this->author?->id),
                'full_name' => $this->whenLoaded('author', fn() => $this->author?->full_name),
            ],

            'cover_image' => $this->cover_image 
                ? asset('storage/' . $this->cover_image) 
                : null,

            'created_at' => $this->created_at?->format('d.m.Y'),
        ];
    }
}