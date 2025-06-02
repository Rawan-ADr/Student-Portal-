<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'fields' => $this->fields->map(function ($field) {
                return [
                    'id' => $field->id,
                    'name' => $field->name,
                    'type' => $field->fieldType->type,  // دمجنا النوع مباشرة هنا
                    'validations' => $field->validation->pluck('validation_rule')->toArray(), // مصفوفة من القيم فقط
                ];
            }),
            'attachments' => $this->attachments->map(function ($attachment) {
                return [
                    'id' => $attachment->id,
                    'name' => $attachment->name,
                    'description' => $attachment->description,
                ];
            }),
        ];
    }
}
