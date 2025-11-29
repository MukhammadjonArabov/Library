<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __invoke(Request $request)
    {
        $perPage = $request->integer('per_page', 15);
        $search  = $request->string('search')->toString();

        $query = Book::with('author');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhereHas('author', fn($q) => $q->whereRaw("CONCAT(name,' ',surname) LIKE ?", ["%{$search}%"]));
            });
        }

        return BookResource::collection(
            $query->latest()->paginate($perPage)
        );
    }

    public function show(Book $book)
    {
        $book->load('author', 'borrowings');

        return new BookResource($book);
    }
}