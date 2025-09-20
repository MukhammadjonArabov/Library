<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['index', 'show']);
        $this->middleware(['auth:sanctum', 'role:Admin, Librarian'])->only(['store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('authors')->get();

        return response()->json([
            'status' => true,
            'data' => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'            => 'required|string|max:255',
            'isbn'             => 'required|string|unique:bokks, isbn',
            'published_year'   => 'required|integer',
            'available_copies' => 'required|integer|min:0',
            'author_ids'       => 'array|exists:authors,id'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 422);
        }

        $book = Book::create($request->only('title', 'isbn', 'published_year', 'available_copies'));

        if ($request->has('author_ids')){
            $book->authors()->sync($request->author_ids);
        }

        return response()->json([
            'status' => true,
            'message' => 'Book created ✅',
            'data' => $book->load('authors')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book->load('authors');

        return response()->json([
            'status' => true,
            'data' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title'            => 'sometimes|required|string|max:255',
            'isbn'             => 'sometimes|required|string|unique:books,isbn,'.$book->id,
            'published_year'   => 'sometimes|required|integer',
            'available_copies' => 'sometimes|required|integer|min:0',
            'author_ids'       => 'sometimes|array|exists:authors,id'
        ]);

        if ($validator->files()){
            return response()->json([
                'status' => true,
                'error'  => $validator->errors()
            ], 422);
        }

        $book = update($request->only('title','isbn','published_year','available_copies'));

        if ($request->has('author_ids')){
            $book->authors()->sync($request->author_ids);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Book updated ✅',
            'data'    => $book->load('authors')
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Book deleted ✅'
        ]);
    }
}
