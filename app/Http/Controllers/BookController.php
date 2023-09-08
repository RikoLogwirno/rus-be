<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBooksRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('author')) {
            $query->where('author', 'like', '%' . $request->input('author') . '%');
        }

        if ($request->has('published_year')) {
            $query->where('published_year', 'like', '%' . $request->input('published_year') . '%');
        }

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $direction = $request->input('order', 'asc'); // Default to ascending order if not specified

            $query->orderBy($sort, $direction);
        }

        $books = $query->get();

        return response()->json(['books' => $books], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBooksRequest $request)
    {
        $validatedData = $request->validated();

        $book = new Book();
        $book->title = $validatedData['title'];
        $book->description = $validatedData['description'];
        $book->authors = $validatedData['authors'];
        $book->published_year = $validatedData['published_year'];
        $book->tags = $validatedData['tags'];

        $book->save();

        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);

        return response()->json(['book' => $book], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBooksRequest $request, $id)
    {
        $validatedData = $request->validated();

        $book = Book::findOrFail($id);

        $book->title = $validatedData['title'];
        $book->description = $validatedData['description'];
        $book->authors = $validatedData['authors'];
        $book->published_year = $validatedData['published_year'];
        $book->tags = $validatedData['tags'];

        $book->save();

        return response()->json(['message' => 'Book updated successfully', 'book' => $book], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return Book::destroy($request->book);
    }
}
