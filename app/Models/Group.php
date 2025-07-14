<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        "course_id",
        "professor_id",
        "group_number"
      
    ];

     public function courses()
    {
        return $this->belongsTo(Course::class);
    }
     public function professors()
    {
        return $this->belongsTo(Professor::class);
    }

    public function students()
{
    return $this->belongsToMany(Student::class, 'group_enrollments');
}

}
