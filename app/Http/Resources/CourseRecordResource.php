<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseRecordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'record_id' => $this->id,
            'exam_date' => $this->exam_date,
            'semester'=>$this->semester->name, 
            'practical_mark' => $this->mark->practical_mark,
            'theoretical_mark' => $this->mark->theoretical_mark,
            'total_mark' => $this->mark->total_mark,
            'status' => $this->mark->status, 
        ];
    }
}
