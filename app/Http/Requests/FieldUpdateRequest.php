<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'field_type_id' => 'required|exists:field_types,id',
            'validation_ids' => 'sometimes|array',
            'validation_ids.*' => 'exists:validations,id',
        ];
    }
}
