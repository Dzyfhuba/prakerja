<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
          'slug' => 'required|regex:/^[a-z0-9-]+$/|unique:products,slug,'.$this->route('product')->id,
          'images' => 'required',
          'price' => 'required',
          'description' => 'required',
          'category_id' => 'required|exists:categories,id',
        ];
    }
}
