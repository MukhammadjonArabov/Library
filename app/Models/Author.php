<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bio'];

    public function books()
    {
        return $this->belogsToMany(Book::class, 'author_book');
    }
}
