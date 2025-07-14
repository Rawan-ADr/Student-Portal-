<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupEnrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'group_id',
        'semester_id'
      
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
