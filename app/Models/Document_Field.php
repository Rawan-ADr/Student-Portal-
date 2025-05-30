<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'field_id'
      
    ];
}
