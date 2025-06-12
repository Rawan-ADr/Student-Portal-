<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'status',
        'point',
        'student_id',
        'document_id'
      
    ];

    public function attachments()
    {
        return $this->belongsToMany(Validation::class,'attchment_values');
    }

    public function fields()
    {
        return $this->belongsToMany(Validation::class,'field_values');
    }
}
