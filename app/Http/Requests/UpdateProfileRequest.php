<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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

            'phone' => 'sometimes|string|max:15|min:11',
            'address' => 'sometimes|string|max:255',
            'date_of_birth' => 'sometimes|date|before:-10 years',
            'image' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
        ];


    }
}
