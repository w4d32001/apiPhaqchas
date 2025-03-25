<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'dni' => ['unique:users', 'digits:8'],
            'phone' => ['required', 'unique:users', 'digits:9'],
            'address' => ['nullable'],
            'birth_date' => ['nullable', 'date', 'before:today'],
        ];
    }
}
