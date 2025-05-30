<?php
namespace App\Repositories;
use App\Models\Validation;

class ValidationRepository implements ValidationRepositoryInterface
{
    public function all()
    {
        return Validation::all();
    }


   
    

}