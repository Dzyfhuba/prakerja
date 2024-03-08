<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:students,name',
        'email' => 'required|email|unique:students,email',
        'favorites' => [
          'required',
          'array',
          function ($attribute, $value, $fail) {
            $allowedValues = ['science', 'computer', 'music', 'art', 'social', '0'];
            foreach ($value as $item) {
              if (!in_array($item, $allowedValues)) {
                $fail($attribute . ' contains an invalid value.');
              }
            }
          }
        ],
      ]);

      if ($validator->fails()) {
        return redirect()->route('students.create')->withErrors($validator)->withInput();
      }

      $payload = $validator->validated();

      Student::create($payload);

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
  public function update(Request $request, Student $student)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          Rule::unique('students', 'name')->ignore($student->id),
        ],
        'email' => [
          'required',
          'email',
          Rule::unique('students', 'email')->ignore($student->id),
        ],
        'favorites' => [
          'required',
          'array',
          function ($attribute, $value, $fail) {
            $allowedValues = ['science', 'computer', 'music', 'art', 'social', '0'];
            foreach ($value as $item) {
              if (!in_array($item, $allowedValues)) {
                $fail($attribute . ' contains an invalid value.');
              }
            }
          },
        ],
      ]);

      if ($validator->fails()) {
        return redirect()->route('students.edit', ['student' => $student->id])
          ->withErrors($validator)
          ->withInput();
      }

      $payload = $validator->validated();

      $student->update($payload);

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
