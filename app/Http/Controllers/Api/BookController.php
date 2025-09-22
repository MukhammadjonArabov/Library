<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function store(Request $request)
    {
        // 🔹 Request validatsiyasi
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'published_year' => 'required|integer',
            'available_copies' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::create($request->only([
            'title', 'isbn', 'published_year', 'available_copies'
        ]));

        $authorRole = Role::where('name', 'Author')->first();

        if ($authorRole) {
            $authorUsers = User::where('role_id', $authorRole->id)->get();

            foreach ($authorUsers as $authorUser) {
                $book->authors()->attach($authorUser->id);
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $book->load('authors')
        ], 201);
    }
}
