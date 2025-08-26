<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_time',
        'end_time',
        'type',
        'doctor_name',
        'semester_id',
        'year_id',
        'course_id',
        'day_id',
        'specialization'
      
    ];


    public function course()
{
    return $this->belongsTo(Course::class);
}

public function day()
{
    return $this->belongsTo(Day::class);
}
}
