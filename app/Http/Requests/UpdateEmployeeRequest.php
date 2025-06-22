<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Employee;

class UpdateEmployeeRequest extends FormRequest
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
    }}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

          $employee = Employee::with('user')->find($this->route('employee_id'));
    $userId = optional($employee?->user)->id;

    $rules = [
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:users,email,' . $userId,
        'password' => 'nullable|string|min:6|confirmed',
        'phone' => 'sometimes|required|string|max:20',
        'department_id' => 'sometimes|required|exists:departments,id',
        'type' => 'sometimes|required|in:normal,practical',
    ];

    if ($this->input('type') === 'practical') {
        $rules['is_practical'] = 'required|boolean';
    }

    return $rules;
    }
}
