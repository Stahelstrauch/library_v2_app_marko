<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookTableController extends Controller
{
    public function __invoke(Request $request)
    {
        $sort = $request->input('sort', 'title');
        $direction = $request->input('direction', 'asc');
        $sortable = [
            'title'  => 'books.title',
            'author' => 'authors.name',
        ];
        $orderBy = $sortable[$sort] ?? 'books.title';

        $books = Book::with('author')
            ->select('books.*')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->orderBy($orderBy, $direction)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.books.table', compact('books'));
    }
}
