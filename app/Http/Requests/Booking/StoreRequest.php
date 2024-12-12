<?php

namespace App\Http\Requests\Booking;

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
            'user_id' => ['required', 'exists:user,id'],
            'field_id' => ['required', 'exists:field,id'],
            'booking_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'total' => ['required', 'numeric'],
        ];
    }
}
