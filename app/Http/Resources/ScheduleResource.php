<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'day' => $this->day->name,
            'lectures' => $this->schedules->map(function ($schedule) {
                return [
                    'course_name' => $schedule->course->name,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'type' => $schedule->type,
                    'doctor_name' => $this->when(!is_null($schedule->doctor_name), $schedule->doctor_name),
                ];
            }),
        ];
    }
}

