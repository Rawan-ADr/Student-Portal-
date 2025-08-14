<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
       
    ];

    public function studentRecords()
{
    return $this->belongsToMany(StudentRecord::class, 'student_notes');
}
}
