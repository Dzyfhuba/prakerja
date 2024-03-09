<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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

Route::get('/', [\App\Http\Controllers\Guest\DashboardController::class, 'index']);
Route::get('/test', [\App\Http\Controllers\Guest\DashboardController::class, 'test']);

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
  Route::get('/', fn()=>redirect()->route('posts.index'))->name('dashboard');
  // Posts Routes
  Route::get('posts', [PostController::class, 'index'])->name('posts.index');
  Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
  Route::post('posts', [PostController::class, 'store'])->name('posts.store')->middleware('role:admin|writer');
  Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
  Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('role:admin|writer');
  Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update')->middleware('role:admin|writer');
  Route::patch('posts/{post}', [PostController::class, 'update'])->name('posts.update')->middleware('role:admin|writer');
  Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('role:admin|writer');

  // Categories Routes
  Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
  Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
  Route::post('categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('role:admin|writer');
  Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
  Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
  Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('role:admin|writer');
  Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('role:admin|writer');
  Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('role:admin|writer');

  Route::middleware('role:admin')->group(function () {
    // Products Routes
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::patch('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Users Routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
  });


  Route::get('/students', [StudentController::class, 'index'])->name('students.index');
  Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
  Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
  Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
  Route::post('/students', [StudentController::class, 'store'])->name('students.store')->middleware('role:admin');
  Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('role:admin');
  Route::patch('/students/{student}', [StudentController::class, 'update'])->name('students.update');
});

require __DIR__ . '/auth.php';
