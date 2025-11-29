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
                  ->orWhereHas('author', fn($q) => 
                      $q->whereRaw("CONCAT(name,' ',surname) LIKE ?", ["%{$search}%"])
                  );
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_id'       => 'required|exists:authors,id',
            'title'           => 'required|string|max:255',
            'isbn'            => 'required|string|max:13|unique:books,isbn',
            'published_year'  => 'required|integer|min:1000|max:' . date('Y'),
            'total_copies'    => 'required|integer|min:1',
            'description'     => 'nullable|string',
            'cover_image'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Dastlab available_copies total_copies bilan tenglashtiriladi
        $validated['available_copies'] = $validated['total_copies'];

        $book = Book::create($validated);

        return new BookResource($book);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'author_id'       => 'sometimes|nullable|exists:authors,id',
            'title'           => 'sometimes|nullable|string|max:255',
            'isbn'            => 'sometimes|nullable|string|max:13|unique:books,isbn,' . $book->id,
            'published_year'  => 'sometimes|nullable|integer|min:1000|max:' . date('Y'),
            'total_copies'    => 'sometimes|nullable|integer|min:1',
            'available_copies'=> 'sometimes|nullable|integer|min:0',
            'description'     => 'nullable|string',
            'cover_image'     => 'nullable|image|max:2048',
        ], [
            'total_copies.min'      => 'Manfiy qiymat mumkin emas',
            'available_copies.min'  => 'Manfiy qiymat mumkin emas',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        
        if (isset($validated['total_copies'])) {
            $difference = $validated['total_copies'] - $book->total_copies;
            $book->available_copies += $difference;
        
        }

    
        if (isset($validated['available_copies'])) {
            $book->available_copies -= $validated['available_copies']; 
            unset($validated['available_copies']); 
        }

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data'    => new BookResource($book),
        ]);
    }
}
