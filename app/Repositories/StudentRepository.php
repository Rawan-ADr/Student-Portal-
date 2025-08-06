<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\StudentFile;
use App\Models\StudentNote;
use App\Models\Note;
use App\Models\StudentRecord;
use Carbon\Carbon;
use App\Http\Resources\StudentRecordResource;
use App\Http\Resources\StudentRecordCollectionResource;

class StudentRepository implements StudentRepositoryInterface
{


    public function findByNationalNumber(string $national_number)
    {
        return Student::where('national_number', $national_number)->first();
    }



    public function find($id)
    {
    
        return Student::find($id)->with('studentFile') 
        ->first();
    
    }

     public function all(){
        $student= Student::all()->select('id','name','lineage','mother_name',
        'father_name','national_number');
        return $student;
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

         $studentFile=StudentFile::create([
            'semester_id' => 1,
            'year_id' => 1,
            'academic_year' => now()->year,
            'student_id' => $request['student_id'],
            'status' => "مستجد",
        ]);
        return $studentRecord;
    }


    public function addNotes($request,$id){

        $studentRecord = StudentRecord::find($id);

        if (!$studentRecord) {
            return null;
        } 

        $note= Note::find($request->input('notes_id'));
        if (!$note) {
            return null;
        }

        $studentNote=StudentNote::create([
            'notes_id'=>$request->input('notes_id'),
            'student_record_id'=>$id
        ]);
        
        $studentRecord = StudentRecord::with(['studentNotes.note'])->find($id);
        return new StudentRecordResource($studentRecord);
    }

    public function indexNotes(){
        $note= Note::all();
        return $note;
    }

    public function getStudentRecords($id){
        $records = StudentRecord::with(['studentNotes.note', 'student', 'year'])
        ->where('student_id', $id)
        ->get();

          return StudentRecordCollectionResource::collection($records);
    }

    public function indexStudentRecords(){
        $records = StudentRecord::with(['studentNotes.note', 'student', 'year'])->get();
          return StudentRecordCollectionResource::collection($records);
    }



}