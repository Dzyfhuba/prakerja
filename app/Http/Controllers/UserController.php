<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $data = User::paginate();

    return view('pages.users.index', [
      'data' => $data
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $roles = Role::all();

    return view('pages.users.form', [
      'roles' => $roles
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(UserStoreRequest $request)
  {
    $user = User::create($request->all());
    $user->syncRoles($request->roles);

    $page = User::paginate();

    return redirect()->route('users.index', [
      'page' => $page->lastPage()
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    $roles = Role::all();
    return view('pages.users.form', [
      'roles' => $roles,
      'item' => $user
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UserUpdateRequest $request, User $user)
  {
    $user->update($request->all());
    $user->syncRoles($request->roles);

    $count = User::where('id', '<=', $user->id)->count();

    return redirect()->route('users.index', [
      'page' => ceil($count / 15)
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
