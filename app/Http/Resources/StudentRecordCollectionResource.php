<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentRecordCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'academic_year' => $this->academic_year,
            'year' => $this->year->name,
            'amount' => $this->amount,
            'result' => $this->result,
            'resregistration_date' => $this->resregistration_date,
            'notes' => $this->studentNotes->map(function ($studentNote) {
                return [
                    'note_id' => $studentNote->note->id,
                    'note_description' => $studentNote->note->name,
                ];
            }),

        ];
    }
}
