<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Route::get('/notes/index', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/show/{id}', [NoteController::class, 'show'])->name('notes.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes/store', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/edit/{id}', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{id}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::get('/notes/search', [NoteController::class, 'search'])->name('notes.search');
    Route::get('/notes/trashed', [NoteController::class, 'trashed'])->name('notes.trashed');
    Route::put('/notes/trashed/{id}', [NoteController::class, 'restore'])->name('notes.restore');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('notes', NoteController::class);
