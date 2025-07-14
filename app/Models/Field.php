<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'field_type_id',
        'processing_by'
      
    ];

    public function document()
    {
        return $this->belongsToMany(Document::class,'document__fields');
    }

    public function validation()
    {
        return $this->belongsToMany(Validation::class,'field__validations');
    }

    public function fieldType()
    {
        return $this->belongsTo(FieldType::class);
    }

   

    public function fieldValues()
    {
        return $this->hasMany(FieldValue::class, 'field_id');
    }
}
