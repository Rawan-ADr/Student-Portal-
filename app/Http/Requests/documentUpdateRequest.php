<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class documentUpdateRequest extends FormRequest
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
            'name' => 'nullable|string',
            'content'=>'nullable',
            'fee' => 'nullable|numeric|min:0',
            'field_ids' => 'nullable|array',
            'field_ids.*' => 'integer|exists:fields,id',
            'attachment_ids' => 'nullable|array',
            'attachment_ids.*' => 'integer|exists:attachments,id',
            'condition_ids' => 'nullable|array',
            'condition_ids.*' => 'integer|exists:conditions,id',
        ];
    }
}
