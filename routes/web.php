<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostController::class, 'home'])->name('home');
Route::get('/annonces', [PostController::class, 'annonces'])->name('annonces');
Route::match(['get'], '/annonces/{id}', [PostController::class, 'more'])->name('annonce.more');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/annonces', [ProfileController::class, 'all'])->name('profile.annonces');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/creation-annonce', [PostController::class, 'creation'])->name('annonce.creation');
    Route::post('/creation-annonce', [PostController::class, 'store'])->name('annonce.store');
    Route::match(['delete'], '/annonces/{id}', [PostController::class, 'destroy'])->name('annonce.destroy');
    Route::post('/annonces/{id}/subscribe', [PostController::class, 'subscribe'])->name('annonces.subscribe');
    Route::delete('/annonces/{annonce}/unsubscribe', [PostController::class, 'unsubscribe'])->name('annonces.unsubscribe');

    Route::get('/taches', [TaskController::class, 'taches'])->name('taches');
    Route::get('/tache-creation', [TaskController::class, 'creation'])->name('tache.creation');
    Route::get('/tache-edit', [TaskController::class, 'edit'])->name('tache.edit');
    Route::put('/tache-edit/{id}', [TaskController::class, 'update'])->name('tache.update');
    Route::match(['delete'], '/taches/{id}', [TaskController::class, 'destroy'])->name('taches.destroy');
    Route::post('/tache-creation', [TaskController::class, 'store'])->name('tache.store');
});

require __DIR__.'/auth.php';
