<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $data = Student::query();
    return view('pages.students.index', [
      'data' => $data->paginate()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('pages.students.form');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StudentStoreRequest $request)
  {
    try {

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => '12345678'
      ]);
      Student::create([
        ...$request->all(),
        'user_id' => $user->id
      ]);
      $user->assignRole('student');

      $page = Student::paginate();

      return redirect()->route('students.index', [
        'page' => $page->lastPage()
      ]);
    } catch (\Exception $e) {
      return redirect()->route('students.create')->withErrors([
        'error' => $e
      ]);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Student $student)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Student $student)
  {
    return view('pages.students.form', [
      'item' => $student
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StudentUpdateRequest $request, Student $student)
  {
    try {
      if (auth()->user()->hasRole('student') && auth()->user()->id != $student->user_id) {
        return abort(404);
      }

      $student->update($request->all());

      return redirect()->route('students.index');
    } catch (\Exception $e) {
      return redirect()->route('students.edit', ['student' => $student->id])
        ->withErrors([
          'error' => 'An error occurred while updating the student.',
        ]);
    }
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Student $student)
  {
    $student->delete();
  }
}
