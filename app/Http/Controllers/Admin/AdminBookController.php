<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminBookController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $books = Book::query()
            ->with('author')
            ->orderBy('title')
            ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $authors = Author::orderBy('name')->get(['id','name']);
        return view('admin.books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'author_id'      => ['required','exists:authors,id'],
            'title'          => ['required','string','min:2','max:255'],
            'published_year' => ['nullable','integer','digits:4','between:1000,2100'],
            'isbn'           => ['nullable','string','max:20', Rule::unique('books','isbn')],
            'pages'          => ['nullable','integer','min:1'],
        ]);

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('status', 'Raamat lisatud.');
    }

    /**
     * Display the specified resource.
     */
    public function show() {
        $books = Book::with('author')->orderBy('title')->paginate(10);
        return view('auth.books', compact('books'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book) {
        $authors = Author::orderBy('name')->get(['id','name']);
        return view('admin.books.edit', compact('book','authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book) {
        $data = $request->validate([
            'author_id'      => ['required','exists:authors,id'],
            'title'          => ['required','string','min:2','max:255'],
            'published_year' => ['nullable','integer','digits:4','between:1000,2100'],
            // Ehk: ISBN peab olema unikaalne kõigi teiste raamatute seas, aga sama rida, mida sa parasjagu uuendad, ei loe “duplikaadiks”.
            'isbn'           => ['nullable','string','max:20', Rule::unique('books','isbn')->ignore($book->id)],
            'pages'          => ['nullable','integer','min:1'],
        ]);

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('status', 'Raamat uuendatud.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)  {
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('status', 'Raamat kustutatud.');
    }
}
