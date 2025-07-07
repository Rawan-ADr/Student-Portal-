<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


    protected $fillable = [
        'name'
      
    ];

    public function lectures()
    {
        return $this->hasMany(Lecture::class,'lectures');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function courseRecords()
    {
        return $this->hasMany(CourseRecord::class);
    }
}


