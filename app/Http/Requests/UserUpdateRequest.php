<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
      'name' => 'required',
      'email' => "required|email|unique:users,email,{$this->route('user')->id},id",
      'password' => 'required',
      'roles' => [
        'required',
        'array',
        Rule::exists('roles', 'name')->whereIn('name', $this->input('roles'))
      ]
    ];
  }
}
