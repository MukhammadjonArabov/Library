<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'full_name' => $this->full_name,
            'birth_date'=> $this->birth_date?->format('Y-m-d'),
            'bio'       => $this->bio,
            'books'     => $this->books->map(function($book){
                return [
                    'id'    => $book->id,
                    'title' => $book->title,
                    'isbn'  => $book->isbn,
                ];
            }),
        ];
    }
}
