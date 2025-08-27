<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResultResource extends JsonResource
{
    public function toArray($request)
    {
         return [
            'id' => $this->id,
            'date' => $this->date,
            'status' => $this->status,
          //  'point' => $this->point,
           // 'modifications' => $this->modifications,

            'fields' => $this->fieldValues
                ->map(function ($fieldValue) {
                    return [
                        'name' => $fieldValue->field->name,
                        'type' => $fieldValue->field->fieldType->type,
                        'value' => $fieldValue->value
                    ];
                }),

            'attachments' => $this->attachmentValues->map(function ($attachmentValue) {
                return [
                    'attachment_name' => $attachmentValue->attachment->name,
                    'file_url' => url('storage/' . $attachmentValue->value)
                ];
            })
        ];
    }
}
