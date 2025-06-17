<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'date',
        'path',
        'type',
        'specialization'
      
    ];

    public function coures()
    {
        return $this->belongsTo(Course::class);
    }
    
  
}
