<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'birth_date', 'bio'];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->name} {$this->surname}");
    }
}