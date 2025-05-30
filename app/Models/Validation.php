<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;

    protected $fillable = [
        'validation_rule',
        'error_message'

      
    ];

    public function field()
    {
        return $this->belongsToMany(Field::class,'field__validations');
    }
}
