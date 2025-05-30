<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition_parameter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'source',
        'condition_id'
      
    ];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}
