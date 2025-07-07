<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentRecordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'academic_year' => $this->academic_year,
            'year'=>$this->year->name,
            'amount' => $this->amount,
            'result' => $this->result,
            'notes' => $this->studentNotes->map(function ($noteRelation) {
                return [
                    'note_id' => $noteRelation->note->id,
                    'note_description' => $noteRelation->note->name,
                ];
            }),

            'resregistration_date' => $this->resregistration_date,
        ];
    }
}
