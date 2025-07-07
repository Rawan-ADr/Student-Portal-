<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'document_name' => $this->document->name,
            'student_name'=>$this->student->name,
            'date' => $this->date,
            'id'=>$this->id
           
          
        ];
    }
}
