<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookImportController extends Controller
{
    public function index() {
    return view('admin.imports.index');}


    public function import(Request $request) {
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');
    $handle = fopen($file->getRealPath(), 'r');

    // Päis jääb vahele
    $header = fgetcsv($handle, 1000, ";");

    $imported = 0;
    $skipped = 0;

    while (($row = fgetcsv($handle, 1000, ";")) !== false) {
        $authorName = trim($row[0] ?? '');
        $title = trim($row[1] ?? '');
        $publishedYear = trim($row[2] ?? null);
        $isbn = trim($row[3] ?? null);
        $pages = trim($row[4] ?? null);

        // Kohustuslikud väljad: autor ja pealkiri
        if ($authorName === '' || $title === '') {
            $skipped++;
            continue;
        }

        // Leia autor või loo uus
        $author = \App\Models\Author::firstOrCreate(['name' => $authorName]);

        // Kontrolli duplikaati (sama autor + sama pealkiri)
        $existingBook = \App\Models\Book::where('author_id', $author->id)
            ->where('title', $title)
            ->first();

        if ($existingBook) {
            $skipped++;
            continue;
        }

        // Salvesta raamat
        \App\Models\Book::create([
            'author_id' => $author->id,
            'title' => $title,
            'published_year' => $publishedYear ?: null,
            'isbn' => $isbn ?: null,
            'pages' => $pages ?: null,
        ]);

        $imported++;
    }

    fclose($handle);

    return redirect()->back()->with([
        'success' => 'CSV edukalt imporditud!',
        'imported' => $imported,
        'skipped' => $skipped,
    ]);
}

}
