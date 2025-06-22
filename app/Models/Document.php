<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content'
      
    ];

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class,'document__attachments');
    } 
    
    public function condition()
    {
        return $this->belongsToMany(Condition::class,'document__conditions');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class,'document__fields');
    }

    public function workflow()
    {
        return $this->belongsToMany(Workflow::class,'document__workflows');
    }



}
