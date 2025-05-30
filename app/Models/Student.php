<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
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
}
