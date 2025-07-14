<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student   extends Authenticatable
{
    use HasFactory , HasApiTokens;

    protected $fillable = [
        'name',
        'lineage',
        'father_name',
        'mother_name',
        'place_of_birth',
        'date_of_birth',
        'registration_place_number',
        'nationality',
        'national_number',
        'university_number',
        'governorate',
        'temporary_address',
        'address',
        'secondary_school',
        'type',
        'acceptance',
        'date_of_secondarySchool_cretificate',
        'total_grades',
        'department'
      
    ];

    public function courseRecords()
    {
        return $this->hasMany(CourseRecord::class);
    }

    public function studentRecords()
    {
        return $this->hasMany(StudentRecord::class);
    }

    public function groupEnrollments()
    {
         return $this->hasMany(GroupEnrollment::class);
    }

    public function groups()
    {
       return $this->belongsToMany(Group::class, 'group_enrollments');
    }


}
