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
            'name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'password' => ['required', 'min:8'],
            'surname' => ['required', 'regex:/^[\pL\s]+$/u'],
            'dni' => ['required', 'unique:users', 'digits:8'],
            'phone' => ['required', 'unique:users', 'digits:9'],
            'rol_id' => ['nullable', 'exists:rols,id'],
            'address' => ['nullable'],
            'birth_date' => ['nullable', 'date', 'before:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'surname.required' => 'El apellido es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'El DNI ya está registrado.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.unique' => 'El teléfono ya está registrado.',
            'phone.digits' => 'El teléfono debe tener exactamente 9 dígitos.',
            'rol_id.exists' => 'El rol seleccionado no es válido.',
            'birth_date.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
        ];
    }
}
