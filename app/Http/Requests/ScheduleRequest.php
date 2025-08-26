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
            'year_id'     => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'day_id'      => 'required|exists:days,id',
            'schedules'   => 'required|array|min:1',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time'   => 'required|date_format:H:i|after:schedules.*.start_time',
            'schedules.*.type'       => 'required|in:نظري,عملي',
            'schedules.*.doctor_name'=> 'nullable|string|max:255',
            'schedules.*.specialization' => 'nullable|in:برمجيات,ذكا صنعي,شبكات',
            'schedules.*.course_id'  => 'required|exists:courses,id',
        ];
    }
}
