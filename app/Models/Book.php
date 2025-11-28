<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'isbn',
        'published_year',
        'total_copies',
        'available_copies',
        'description',
        'cover_image',
    ];

    protected $casts = [
        'published_year' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function scopeSearch($query, $term)
    {
        if (!$term) return $query;

        return $query->where('title', 'like', "%{$term}%")
                     ->orWhere('isbn', 'like', "%{$term}%")
                     ->orWhereHas('author', fn($q) => $q->where('name', 'like', "%{$term}%")
                                                       ->orWhere('surname', 'like', "%{$term}%"));
    }
    
    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    public function borrowCount()
    {
        return $this->borrowings()->count();
    }
}