<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostJobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\CategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
   Route::get('/job-types', [JobTypeController::class, 'index'])->name('job-types.index');
Route::post('/job-types', [JobTypeController::class, 'store'])->name('job-types.store');
Route::post('/job-types/{id}', [JobTypeController::class, 'update'])->name('job-types.update');
Route::delete('/job-types/{id}', [JobTypeController::class, 'destroy'])->name('job-types.destroy');
Route::get('/job-types/edit/{id}', [JobTypeController::class, 'edit'])->name('job-types.edit');


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');


Route::resource('/jobs', PostJobController::class);

    Route::resource('job-types', JobTypeController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update-profile-pic', [ProfileController::class, 'updateProfilePic'])->name('ProfilePic');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
