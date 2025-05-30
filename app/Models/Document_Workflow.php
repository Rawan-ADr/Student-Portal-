<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'workflow_id'
      
    ];
}
