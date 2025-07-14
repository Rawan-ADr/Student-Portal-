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
        'password' => 'nullable|string|min:6',
        'phone' => 'sometimes|required|string|max:20',
        'department_id' => 'sometimes|required|exists:departments,id',
        'type' => 'sometimes|required|in:normal,practical',
    ];

    return $rules;
    }
}
