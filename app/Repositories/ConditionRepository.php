<?php
namespace App\Repositories;
use App\Models\Condition;

class ConditionRepository implements ConditionRepositoryInterface
{

     public function all()
    {
        return Condition::select('id','name')->get();
    }

    

    
}