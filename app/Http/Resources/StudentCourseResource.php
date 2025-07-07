<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'course_id' => $this->id,
            'name' => $this->course->name,
            
        ];
    }
}