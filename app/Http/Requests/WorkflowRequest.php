<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkflowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
{
    $steps = $this->input('steps', []);

    foreach ($steps as $index => $step) {
        if (isset($step['is_final'])) {
            $steps[$index]['is_final'] = filter_var($step['is_final'], FILTER_VALIDATE_BOOLEAN);
        }
    }

    $this->merge([
        'steps' => $steps
    ]);
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document_id' => 'required|exists:documents,id',
            'name' => 'required|string|max:255',
            'steps' => 'required|array|min:1',
            'steps.*.step_name'=>'required|string',
            'steps.*.is_final' =>  'required|boolean',
            'steps.*.step_order' => 'required|integer',
            'steps.*.role_id' => 'required|exists:roles,id',
        ];
    }
}
