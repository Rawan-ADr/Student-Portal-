<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRecordRequest extends FormRequest
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
            'amount' => 'required|string|max:255',
            'result' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'academic_year' => 'required|regex:/^\d{4}-\d{4}$/',
            'student_id' => 'required|exists:students,id',
            'year_id' => 'required|exists:years,id',
        ];
    }
}
