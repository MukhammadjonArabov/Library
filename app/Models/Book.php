<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'isbn', 'published_year', 'available_copies'];

    public function authors()
    {
        return $this->belongsToMany(User::class, 'book_user', 'book_id', 'user_id')
                    ->whereHas('role', function ($query) {
                        $query->where('name', 'Author');
                    });
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}


