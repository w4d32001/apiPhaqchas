<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required'],
            'password' => ['required', 'min:8'],
            'surname' => ['required'],
            'dni' => ['required', 'unique:users', 'digits:8'],
            'phone' => ['required', 'unique:users', 'digits:9'],
            'rol_id' => ['nullable', 'exists:rols,id'],
            'address' => ['nullable'],
            'birth_date' => ['nullable', 'date', 'before:today'],
        ];
    }
}
