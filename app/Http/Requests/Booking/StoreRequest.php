<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

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
            'user_id' => ['required', 'exists:users,id'],
            'field_id' => ['required', 'exists:fields,id'],
            'sport_id' => ['required', 'exists:sports,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'price' => ['nullable', 'numeric'],
            'yape' => ['nullable', 'numeric'],
        ];
    }
    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $start = Carbon::createFromFormat('H:i', $this->start_time);
            $end = Carbon::createFromFormat('H:i', $this->end_time);

            if (!$end->isAfter($start)) {
                $validator->errors()->add('end_time', 'El horario de fin debe ser posterior al inicio.');
            } elseif ($end->diffInMinutes($start) % 60 !== 0) {
                $validator->errors()->add('end_time', 'La duración debe ser en bloques de horas completas.');
            }

            if ($start->hour < 8 || $start->hour >= 22) {
                $validator->errors()->add('start_time', 'El horario de inicio debe estar entre las 08:00 y las 22:00.');
            }

            if ($end->hour < 8 || $end->hour > 22 || ($end->hour == 22 && $end->minute != 0)) {
                $validator->errors()->add('end_time', 'El horario de fin debe estar entre las 08:00 y las 22:00.');
            }
        });
    }

}





