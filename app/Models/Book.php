<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'isbn', 'published_year', 'available_copies'];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_book');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
