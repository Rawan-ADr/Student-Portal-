<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'semester_id',
        'exam_date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function mark()
    {
        return $this->hasOne(Mark::class);
    }

}
