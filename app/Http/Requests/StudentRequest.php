<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'lineage' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'registration_place_number' => 'required|string|max:50',
            'nationality' => 'required|string|max:100',
            'national_number' => 'required|digits:11|unique:students,national_number',
            'governorate' => 'required|string|max:100',
            'temporary_address' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'secondary_school' => 'required|string|max:255',
            'type' => 'required|in:scientific,vocational',
            'acceptance' => 'required|in:general,parallel',
            'date_of_secondarySchool_cretificate' => 'required|date|before_or_equal:today',
            'total_grades' => 'required|integer|min:0',
            'department' => 'nullable|string|max:255',
        ];
    }
}
