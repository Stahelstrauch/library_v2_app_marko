<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $books = null;

        if ($request->has('query')) {
            // Eemaldame alguse/lõpu tühikud
            $query = trim($request->input('query'));

            // Kontrollime, et vähemalt 3 märki oleks pärast trimmimist
            if (mb_strlen($query) < 3) {
                return back()->withInput()->with('error', 'Palun sisesta vähemalt 3 märki.');
            }

            // Teeme otsingu
            $books = Book::with('author')
                ->where('title', 'like', '%' . $query . '%')
                ->orWhere('published_year', 'like', '%' . $query . '%')
                ->orWhere('pages', 'like', '%' . $query . '%')
                ->orWhereHas('author', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->get();
        }

        return view('public.search', compact('books'));
    }
}
