<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

     protected function prepareForValidation()
{
    if ($this->input('type') === 'practical') {
        $this->merge([
            'is_practical' => filter_var($this->input('is_practical', false), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'phone' => 'required|string|max:20',
        'department_id' => 'required|exists:departments,id',
        'type' => 'required|in:normal,practical',
    ];

    if ($this->input('type') === 'practical') {
        $rules['is_practical'] = 'required|boolean';
    }

    return $rules;
        
    }
}
