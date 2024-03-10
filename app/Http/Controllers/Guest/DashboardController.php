<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
  protected $seed;
  public function __construct() {
    $seed = Cache::get('seed', random_int(1, 5));
    if (!Cache::has('seed')) Cache::put('seed', $seed, now()->addHour());
    $this->seed = $seed;
  }
  public function index()
  {
    $posts = Post::query()->inRandomOrder($this->seed)->limit(5)->with('user')->get();
    $categories = Category::query()
      ->inRandomOrder($this->seed)->has('products')->with('products')->get();
    $products = Product::query()->inRandomOrder($this->seed)->limit(5)->get();
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

  public function product(Product $product)
  {
    $products = Product::query()->whereNot('id', $product->id)->inRandomOrder($this->seed)->limit(5)->get();
    $posts = Post::query()->inRandomOrder($this->seed)->limit(5)->get();
    return inertia('Product', [
      'item' => $product,
      'products' => $products,
      'posts' => $posts,
    ]);
  }

  public function post(Post $post)
  {
    return inertia('Post', [
      'item' => $post
    ]);
  }
}
