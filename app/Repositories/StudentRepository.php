<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\StudentRecord;
use Carbon\Carbon;

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

    public function createStudent($request){

        $student = Student::create($request); 
        return $student;
    }


    public function createStudentRecord($request){

        $studentRecord = StudentRecord::create([
            'amount' => $request['amount'],
            'result' => $request['result'],
            'notes' => $request['notes'] ?? null,
            'academic_year' => $request['academic_year'],
            'resregistration_date' => Carbon::today(),
            'student_id' => $request['student_id'],
            'year_id' => $request['year_id'],
        ]); 
        return $studentRecord;
    }


    public function addNotes($request,$id){

        $studentRecord = StudentRecord::find($id);

        if (!$studentRecord) {
            return null;
        } 

        $studentRecord->update([
            'notes' => $request->input('notes')
        ]);
        return $studentRecord;
    }

    


}