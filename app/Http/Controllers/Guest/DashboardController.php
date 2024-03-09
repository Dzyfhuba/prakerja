<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    $posts = Post::query()->orderBy('updated_at', 'desc')->limit(5)->with('user')->get();
    $categories = Category::query()
      ->orderBy('updated_at', 'desc')->has('products')->with('products')->get();
    $products = Product::query()->orderBy('updated_at', 'desc')->limit(5)->get();
    return inertia('Dashboard', [
      'posts' => $posts,
      'categories' => $categories,
      'products' => $products
    ]);
  }
  public function test()
  {
    return inertia('Test');
  }
}
