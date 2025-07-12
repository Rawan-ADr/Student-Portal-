<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:Theoretical,Parctical',
            'semester_id' => 'required|exists:semesters,id',
            'year_id' => 'required|exists:years,id',
            'course_id' => 'required|exists:courses,id',
            'day_id' => 'required|exists:days,id',
            'doctor_name' => 'nullable|string|max:255'
        ];
    }
}
