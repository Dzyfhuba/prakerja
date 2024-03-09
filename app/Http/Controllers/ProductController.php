<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\Uid\Ulid;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $data = Product::paginate();

    return view('pages.products.index', [
      'data' => $data
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $categories = Category::all();
    return view('pages.products.form', [
      'categories' => $categories
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProductStoreRequest $request)
  {
    $images = $request->file('images');

    $paths = [];

    foreach ($images as $image) {
      // Generate ULID as the new filename
      $ulid = (string) Ulid::generate();
      $newFilename = $ulid . '.' . $image->getClientOriginalExtension();

      // Move the image to the storage directory
      $image->storeAs('products', $newFilename, 'public');

      $paths[] = "/storage/products/" . $newFilename;
    }

    $request->merge([
      'images' => 'asdas',
    ]);

    Product::create([
      ...$request->except('images'),
      'images' => $paths
    ]);

    $page = Product::paginate();

    return redirect()->route('products.index', [
      'page' => $page->lastPage()
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Product $product)
  {
    $category = Category::all();
    return view('pages.products.form', [
      'item' => $product,
      'categories' => $category
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ProductUpdateRequest $request, Product $product)
  {
    $images = $request->file('images');

    $paths = [];

    foreach ($images as $image) {
      // Generate ULID as the new filename
      $ulid = (string) Ulid::generate();
      $newFilename = $ulid . '.' . $image->getClientOriginalExtension();

      // Move the image to the storage directory
      $image->storeAs('products', $newFilename, 'public');

      $paths[] = "/storage/products/" . $newFilename;
    }

    $product->update([
      ...$request->except('images'),
      'images' => $paths,
    ]);

    $count = Product::where('id', '<=', $product->id)->count();

    return redirect()->route('products.index', [
      'page' => ceil($count / 15)
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product)
  {
    $product->delete();

    return redirect()->route('products.index');
  }
}
