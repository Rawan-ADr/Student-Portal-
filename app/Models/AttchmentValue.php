<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttchmentValue extends Model
{
    use HasFactory;

    protected $fillable = [
       'value',
        'attachment_id',
        'request_id'
      
    ];


   

}
