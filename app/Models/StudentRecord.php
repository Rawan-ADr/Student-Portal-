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
        'notes',
        'academic_year',
        'resregistration_date',
        'student_id',
        'year_id',
    ];
}
