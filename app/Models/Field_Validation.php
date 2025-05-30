<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field_Validation extends Model
{
    use HasFactory;

    protected $fillable = [
        'validation_id',
        'field_id'
      
    ];
}
