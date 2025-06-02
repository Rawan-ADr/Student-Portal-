<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type'
      
    ];

    public function fields()
    {
        return $this->hasMany(Field::class,'field_types');
    }

}
