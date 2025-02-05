<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdmin extends FormRequest
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
            'surname' => ['required'],
            'dni' => ['required', 'digits:8', 'unique:users,dni,' . $this->route('id')],
            'phone' => ['required', 'digits:9', 'unique:users,phone,' . $this->route('id')], 
        ];
    }
}
