<?php
namespace App\Repositories;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{


    public function findByNationalNumber(string $national_number)
    {
        return Student::where('national_number', $national_number)->first();
    }



    public function find($id)
    {
    
        return Student::find($id);
    
    }


}