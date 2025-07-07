<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'result',
        'academic_year',
        'resregistration_date',
        'student_id',
        'year_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function studentNotes()
    {
        return $this->hasMany(StudentNote::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

}
