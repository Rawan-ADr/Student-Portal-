<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'deviceable_id',
        'deviceable_type',
        'device_token',
        'device_type',
    ];

    public function deviceable()
    {
        return $this->morphTo();
    }
}
