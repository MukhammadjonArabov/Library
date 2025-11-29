<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    protected $filable = [
        'book_id',
        'user_id',
        'borrower_name',
        'due_date',
        'returned_at',
        'notes',
    ];

    protected $dates = ['borrowed_at', 'due_date', 'returned_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue(): bool
    {
       return is_null($this->returned_at) && Carbon::now()->gt($this->due_date);
    }

    public function isReturned(): bool
    {
        return !is_null($this->returned_at);
    }
}
