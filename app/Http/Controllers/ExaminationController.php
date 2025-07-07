<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MarkRequest;
use App\Http\Responses\Response;
use App\Services\ExaminationService;

class ExaminationController extends Controller
{

    private ExaminationService $examinationService;

    public function __construct(ExaminationService $examinationService){
       $this->examinationService = $examinationService;
    }



    public function importMarks(MarkRequest $request)
    {

        $data=[];
     try{
         $data=$this->examinationService->importMarks($request->validated());
         return Response::Success($data['data'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }



    public function getStudentCourses()
    {

        $data=[];
     try{
         $data=$this->examinationService->getStudentCourses();
         return Response::Success($data['courses'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getStudentMark($id)
    {

        $data=[];
     try{
         $data=$this->examinationService->getStudentMark($id);
         return Response::Success($data['marks'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getExamRequests()
    {

        $data=[];
     try{
         $data=$this->examinationService->getExamRequests();
         return Response::Success($data['requests'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getRequestData($id)
    {

        $data=[];
     try{
         $data=$this->examinationService->getRequestData($id);
         return Response::Success($data['request'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }


    public function passingRequests($id)
    {

        $data=[];
     try{
         $data=$this->examinationService->passingRequests($id);
         return Response::Success($data['step'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    



}
