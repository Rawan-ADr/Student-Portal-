<?php
namespace App\Repositories;
use App\Models\FieldType;

class TypeRepository implements TypeRepositoryInterface
{
    public function all()
    {
        return FieldType::all();
    }


   
    

}