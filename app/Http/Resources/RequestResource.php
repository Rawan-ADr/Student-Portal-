<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    public function toArray($request)
    {
         return [
            'id' => $this->id,
            'docment_id'=>$this->document->id,
            'name'=>$this->document->name,
            'date' => $this->date,
            'status' => $this->status,
            'point' => $this->point,
            'modifications' => $this->modifications,

            'fields' => $this->fieldValues
                ->filter(function($fieldValue) {
                    // نحتفظ فقط بالحقول التي processing_by = 'student'
                    return $fieldValue->field->processing_by === 'student';
                })
                ->map(function ($fieldValue) {
                    return [
                        'name' => $fieldValue->field->name,
                        'type' => $fieldValue->field->fieldType->type,
                        'value' => $fieldValue->value,
                         'validations' => $fieldValue->field->validation->pluck('validation_rule')->toArray(),
                    ];
                }),

            'attachments' => $this->attachmentValues->map(function ($attachmentValue) {
                return [
                    'name' => $attachmentValue->attachment->name,
                    'file_url' => url('storage/' . $attachmentValue->value)
                ];
            })
        ];
    }
}
