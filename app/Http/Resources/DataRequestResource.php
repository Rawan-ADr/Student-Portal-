<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DataRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'document_name' => $this->document->name,
            'document_content' => $this->document->content,
            'date' => $this->date,
            'fields' => $this->fieldValues->map(function ($value) {
                return [
                    'field_name' => $value->field->name,
                    'value' => $value->value,
                ];
            }),
            'attachments' => $this->attachmentValues->map(function ($value) {
                return [
                    'attachment_name' => $value->attachment->name,
                    'file_url' => url('storage/' . $value->value)
                ];
            }),
            'conditions' => $this->document->condition->map(function ($condition) {
                return [
                    'text' => $condition->name
                ];
            }),
        ];
    }
}
