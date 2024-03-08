<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $query = Student::query()
      ->where(function ($query) use ($request) {
        if ($request->query('search')) {
          $search = strtolower($request->query('search'));
          $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%");
        }
      });

    if ($request->query('orderBy') && $request->query('orderDirection')) {
      $query->orderBy($request->query('orderBy'), $request->query('orderDirection'));
    }

    return response([
      'data' => $query->get()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StudentStoreRequest $request)
  {
    try {
      $item = Student::create($request->all());

      return response([
        'item' => $item
      ], 201);
    } catch (Exception $e) {
      return response([
        'error' => $e,
        'message' => 'Internal Server Error'
      ]);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Student $student)
  {
    try {
      return response([
        'item' => $student
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'error' => $e,
        'message' => 'Internal Server Error'
      ], 500);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StudentUpdateRequest $request, Student $student)
  {
    try {
      $student->update($request->all());

      return response([
        'item' => $student
      ], 201);
    } catch (Exception $e) {
      return response()->json([
        'error' => $e,
        'message' => 'Internal Server Error'
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Student $student)
  {
    try {
      $student->delete();

      return response([
        'item' => $student
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'error' => $e,
        'message' => 'Internal Server Error'
      ], 500);
    }
  }
}
