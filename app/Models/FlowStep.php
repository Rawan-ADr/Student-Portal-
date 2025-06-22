<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlowStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'workflow_id',
        'step_order',
        'is_final',
        'step_name'
      
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
