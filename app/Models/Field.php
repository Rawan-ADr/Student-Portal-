<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'field_type_id'
      
    ];

    public function document()
    {
        return $this->belongsToMany(Document::class,'document__fields');
    }

    public function validation()
    {
        return $this->belongsToMany(Validation::class,'field__validations');
    }

    public function type()
    {
        return $this->belongsTo(FieldType::class,'field_types');
    }
}
