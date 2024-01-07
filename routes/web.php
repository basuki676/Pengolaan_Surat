<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LetterTypeController;
use App\Http\Controllers\LetterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('isGuest')->group(function () {
    // ketika akses link pertama kali yang di munculkan halaman login
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'authLogin'])->name('auth.login');
});


Route::middleware('isLogin')->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::middleware('isStaff')->group(function () {
        // kalau 1 halaman banyak fitur nya bisa pakai prefix 
        Route::prefix('/user/guru')->name('user.guru.')->group(function () {
            Route::get('/data', [UserController::class, 'getDataGuru'])->name('data');
            Route::get('/create', [UserController::class, 'createGuru'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/search', [UserController::class, 'searchGuru'])->name('search');
            Route::get('/edit{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/update{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete{id}', [UserController::class, 'destroy'])->name('delete');
        });
        Route::prefix('/user/staff')->name('user.staff.')->group(function () {
            Route::get('/data', [UserController::class, 'getDataStaff'])->name('data');
            Route::get('/create', [UserController::class, 'createStaff'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/search', [UserController::class, 'searchStaff'])->name('search');
            Route::get('/edit{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/update{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete{id}', [UserController::class, 'destroy'])->name('delete');
        });
        Route::prefix('/letter/classificate')->name('letter.classificate.')->group(function () {
            Route::get('/data', [LetterTypeController::class, 'getClassificate'])->name('data');
            Route::post('/store', [LetterTypeController::class, 'store'])->name('store');
            Route::get('/create', [LetterTypeController::class, 'createClassificate'])->name('create');
            Route::get('/search', [LetterTypeController::class, 'searchClassificate'])->name('search');
            Route::get('/detail{letter_code}', [LetterTypeController::class, 'show'])->name('detail');
            Route::get('/edit{id}', [LetterTypeController::class, 'edit'])->name('edit');
            Route::patch('/update{id}', [LetterTypeController::class, 'update'])->name('update');
            Route::delete('/delete{id}', [LetterTypeController::class, 'destroy'])->name('delete');
            Route::get('/download-excel', [letterTypeController::class, 'downloadExcel'])->name('download-excel');
        });
        Route::prefix('/letter/letters')->name('letter.letters.')->group(function() {
            Route::get('/data', [LetterController::class, 'getLetters'])->name('data');
            Route::get('/create', [LetterController::class, 'createLetters'])->name('create');
            Route::post(' /store', [LetterController::class, 'store'])->name('store');
            Route::get('/search', [LetterController::class, 'searchLetters'])->name('search'); 
            Route::get('/trix', 'TrixController@index');
            Route::post('/upload', 'TrixController@upload');
            Route::post('/store', 'TrixController@store');
            Route::get('/edit{id}', [LetterController::class, 'edit'])->name('edit');
            Route::get('/show{id}', [LetterController::class, 'show'])->name('show');
            Route::patch('/update{id}', [LetterController::class, 'update'])->name('update');
            Route::delete('/delete{id}', [LetterController::class, 'destroy'])->name('delete');
            Route::get('/download-excel', [letterController::class, 'downloadExcel'])->name('download-excel');
            Route::get('/download-pdf{id}',[LetterController::class, 'downloadPDF'])->name('download-pdf');

        });
    });
    Route::middleware('isGuru')->group(function () {
        Route::prefix('/result')->name('result.')->group(function () {
            Route::get('/data', [ResultController::class, 'index'])->name('data');
            Route::get('/create{id}', [ResultController::class, 'create'])->name('create');
            Route::post('/store{id}', [ResultController::class, 'store'])->name('store');
            Route::get('/show{id}', [ResultController::class, 'show'])->name('show');
            Route::get('/search', [ResultController::class, 'search'])->name('search');
        });
        });
    });