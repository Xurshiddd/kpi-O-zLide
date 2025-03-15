<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'first_name' => 'required',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email',
            'position' => 'nullable|string',
            'region_id' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'department_id' => 'required',
            'address' => 'nullable|string',
            'phone' => 'required|string|min:9|max:13',
            'password' => 'nullable|min:6',
            'roles' => 'required|array'
        ];
    }
}
