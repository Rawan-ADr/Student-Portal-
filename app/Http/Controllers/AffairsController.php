<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\AffairsService;
use App\Http\Requests\StudentRecordRequest;
use App\Http\Requests\StudentRequest;

class AffairsController extends Controller
{
    
    private AffairsService $AffairsService;

    public function __construct(AffairsService $AffairsService){
       $this->AffairsService = $AffairsService;
    }




    public function getStudentRecords($id)
    {

        $data=[];
     try{
         $data=$this->AffairsService->getStudentRecords($id);
         return Response::Success($data['studentRecord'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function addStudent(StudentRequest $request)
    {

        $data=[];
     try{
         $data=$this->AffairsService->addStudent($request->validated());
         return Response::Success($data['student'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }


    }

    public function addStudentRecord(StudentRecordRequest $request)
    {

        $data=[];
     try{
         $data=$this->AffairsService->addStudentRecord($request->validated());
         return Response::Success($data['studentRecord'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function addNotes(Request $request,$id)
    {

        $data=[];
     try{
         $data=$this->AffairsService->addNotes($request,$id);
         return Response::Success($data['studentRecord'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }


   }



}
