<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('pages.students');
  }

  public function get(Request $request)
  {
    $data = Student::all();
    // $data = $data->map(fn ($student, $idx) => ([
    //   ...$student,
    //   'action' => "<button class='btn btn-primary d-block ml-auto' id='edit{$student->id}' data-toggle='modal' data-target='#formModal'>
    //                 Create
    //             </button>"
    // ]));
    return response([
      'data' => $data->map(fn($item) => array_values($item->toArray())),
      'draw' => $request->draw,
      "recordsTotal" => $data->count(),
      "recordsFiltered" => $data->count(),
      "request" => $request->all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
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
        return response([
          'error' => $validator->getMessageBag(),
          'message' => 'Your input is not correct'
        ], 400);
      }

      $payload = $validator->validated();

      $item = Student::create($payload);

      return response([
        'item' => $item,
        'message' => 'Successfully created a new student.'
      ], 201);
    } catch (\Exception $e) {
      return response([
        'error' => $e,
        'message' => 'Something has encountered an error on the server. Please contact the developer.'
      ], 500);
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
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Student $student)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Student $student)
  {
    //
  }
}
