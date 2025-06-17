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


    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }

}
