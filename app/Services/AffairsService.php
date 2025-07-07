<?php


namespace App\Services;
use App\Repositories\StudentRepositoryInterface;

class AffairsService
{

    private  $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository){
        $this->studentRepository = $studentRepository;
    }

    public function addStudent($request){
        $student=$this->studentRepository->createStudent($request);
        if(!$student){
            $student=null;
            $message="error...";
            $code=404;
        }
        $message="student add successfully";
        $code=200; 

        return ['student'=>$student,'message'=>$message,'code'=>$code];

    }

    public function addStudentRecord($request){
        $studentRecord=$this->studentRepository->createStudentRecord($request);
        if(!$studentRecord){
            $studentRecord=null;
            $message="error...";
            $code=404;
        }
        else{
        $message="studentRecord add successfully";
        $code=200; }

        return ['studentRecord'=>$studentRecord,'message'=>$message,'code'=>$code];

    }


    public function addNotes($request,$id){

        $request->validate([
            'notes_id' => 'required|exists:notes,id',
        ]);

        $studentRecord=$this->studentRepository->addNotes($request,$id);
        
        if(is_null($studentRecord))
        {
            $studentRecord=null;
            $message="record or node not found";
            $code=404;
        }

        else{
        $message="Notes add successfully";
        $code=200; 
        }

        return ['studentRecord'=>$studentRecord,'message'=>$message,'code'=>$code];

    }

    public function getStudentRecords($id){
        $studentRecord=$this->studentRepository->getStudentRecords($id);
        if($studentRecord->isEmpty()){
            $message="studentRecord not found";
            $code=404;
        }
        else{
        $message="studentRecord get successfully";
        $code=200; 
        }

        return ['studentRecord'=>$studentRecord,'message'=>$message,'code'=>$code];
    }

}