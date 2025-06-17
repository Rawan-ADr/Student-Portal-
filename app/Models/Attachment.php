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
        'type',
        'id'
      
    ];

    public function document()
    {
        return $this->belongsToMany(Document::class,'document__attachments');
    }

    public function attachmentValues()
    {
        return $this->hasMany(AttchmentValue::class, 'attachment_id');
    }

}

