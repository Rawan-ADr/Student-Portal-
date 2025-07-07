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
        'modifications',
        'student_id',
        'document_id'
      
    ];
    public function fieldValues()
    {
        return $this->hasMany(FieldValue::class, 'request_id');
    }

    
    public function attachmentValues()
    {
        return $this->hasMany(AttchmentValue::class, 'request_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
