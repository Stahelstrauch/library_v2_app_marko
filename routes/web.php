<?php

use App\Http\Controllers\Admin\AdminAuthorController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Public\AuthorController;
use App\Http\Controllers\Public\BookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

# Laravelis lisab automaatselt kõik tüüpilised autentimise (login, logout, register, password reset, verify) 
# marsruudid ilma, et peaksid neid käsitsi routes/web.php faili kirjutama. Kontrollerid asuvad
# app/Http/Controllers/Auth/
Auth::routes(['register' => false]); //Avalik regamine keelatud

// tänu __invoke() meetodile pole vaja meetodit lisada (index, show, create ...)
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'force.password.change'])
    ->name('dashboard');

# Avaliku vaate route-d
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

# Admin vaate osad
Route::middleware(['auth', 'force.password.change'])->prefix('admin')->name('admin.')->group(function () {
    // Adminile mõeldud osa
    Route::middleware('can:manage-users')->group(function() {
        // Autorite ja raamatute haldamine
        Route::resource('authors', AdminAuthorController::class)->except(['show']);
        Route::resource('books',   AdminBookController::class)->except(['show']);
        // Loo ja salvesta uut kasutajat
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
    });

    
    // Kõikidele sisseloginutele parooli muutmine
    Route::get('/password/change', [ChangePasswordController::class, 'edit'])->name('password.change');
    Route::put('/password/change', [ChangePasswordController::class, 'update'])->name('password.update');

});

