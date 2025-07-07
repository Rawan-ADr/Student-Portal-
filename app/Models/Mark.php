<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_record_id',
        'practical_mark',
        'theoretical_mark',
        'total_mark', 'status'
    ];

    public function courseRecord()
    {
        return $this->belongsTo(CourseRecord::class);
    }
}
