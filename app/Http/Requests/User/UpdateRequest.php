<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'min:8'],
            'surname' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'digits:8', "unique:users,dni,{$this->user}"],
            'phone' => ['required', 'digits:9', "unique:users,phone,{$this->user}"],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before:today'],
        ];
    }
}
