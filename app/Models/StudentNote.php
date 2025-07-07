<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_record_id',
        'notes_id',
       
    ];

    public function note()
    {
        return $this->belongsTo(Note::class, 'notes_id');
    }
}
