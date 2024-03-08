<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
  Route::resource('posts', PostController::class);
  Route::resource('categories', CategoryController::class);
  Route::resource('products', ProductController::class);

  Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/students', [StudentController::class, 'index'])->name('students.index');
  Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
  Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
  Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
  Route::post('/students', [StudentController::class, 'store'])->name('students.store')->middleware('role:admin');
  Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('role:admin');
  Route::patch('/students/{student}', [StudentController::class, 'update'])->name('students.update');
});

require __DIR__ . '/auth.php';
