<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'type'
      
    ];

    public function document()
    {
        return $this->belongsToMany(Document::class,'document__attachments');
    }
}
