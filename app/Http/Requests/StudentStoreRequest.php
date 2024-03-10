<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StudentStoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
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
      ]
    ];
  }

  protected function failedValidation(Validator $validator): void
  {
    $response = $this->is('api/*')
      ? $this->apiErrorResponse($validator)
      : $this->webErrorResponse($validator);

    throw new HttpResponseException($response);
  }

  protected function apiErrorResponse(Validator $validator): JsonResponse
  {
    return new JsonResponse([
      'message' => 'Validation failed',
      'errors' => $validator->errors(),
    ], 400);
  }

  protected function webErrorResponse(Validator $validator)
  {
    return redirect()->back()->withErrors($validator)->withInput();
  }
}
