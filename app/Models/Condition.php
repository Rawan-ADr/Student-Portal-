<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'validation_query',
        'error_message'
      
    ];

    public function document()
    {
        return $this->belongsToMany(Document::class,'document__conditions');
    }

    public function parameter()
    {
        return $this->hasMany(Condition_parameter::class);
    }

}
