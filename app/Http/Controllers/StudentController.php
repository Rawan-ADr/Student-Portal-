<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\StudentService;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\RequestRequest;
use App\Http\Requests\StudentLoginRequest;
use App\Http\Requests\StudentRecordRequest;
use App\Http\Requests\ScheduleRequest;

class StudentController extends Controller
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService){
       $this->studentService = $studentService;
    }


    public function login(StudentLoginRequest $request)
    {

        $data=[];
     try{
         $data=$this->studentService->login($request->validated());
         return Response::Success($data['student'],$data['message'],$data['code']) ;
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
         $data=$this->studentService->addStudent($request->validated());
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
         $data=$this->studentService->addStudentRecord($request->validated());
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
         $data=$this->studentService->addNotes($request,$id);
         return Response::Success($data['studentRecord'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }


   }

    public function logout(){

        $data=[];
       try{
         $data=$this->studentService->logout();
         return Response::Success($data['student'],$data['message'],$data['code']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }
    }

    public function getStudent($id)
    {

        $data=[];
     try{
         $data=$this->studentService->getStudent($id);
         return Response::Success($data['student'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getReceivedRequest($id)
    {

        $data=[];
     try{
         $data=$this->studentService->getReceivedRequest($id);
         return Response::Success($data['requests'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }


    
    public function getRequest($id)
    {

        $data=[];
     try{
         $data=$this->studentService->getRequest($id);
         return Response::Success($data['requests'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getDocument($id)
    {

        $data=[];
     try{
         $data=$this->studentService->getDocument($id);
         return Response::Success($data['document'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function sendRequest(RequestRequest $request,$document_id)
    {

        $data=[];
     try{
         $data=$this->studentService->sendRequest($request,$document_id);
         return Response::Success($data['request'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getLecture(Request $request)
    {

        $data=[];
     try{
         $data=$this->studentService->getLecture($request);
         return Response::Success($data['lectures'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }


    public function getCourse(Request $request)
    {

        $data=[];
     try{
         $data=$this->studentService->getCourse($request);
         return Response::Success($data['courses'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }


    public function getSemester()
    {

        $data=[];
     try{
         $data=$this->studentService->getSemester();
         return Response::Success($data['semester'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getYears()
    {

        $data=[];
     try{
         $data=$this->studentService->getYears();
         return Response::Success($data['Years'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }
///////////////......
    public function addLecture(Request $request)
    {

        $data=[];
     try{
         $data=$this->studentService->addLecture($request);
         return Response::Success($data['lecture'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

///////////////..........
    public function addAnnouncement(Request $request)
    {

        $data=[];
     try{
         $data=$this->studentService->addAnnouncement($request);
         return Response::Success($data['Announcement'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function getAnnouncement()
    {

        $data=[];
     try{
         $data=$this->studentService->getAnnouncement();
         return Response::Success($data['Announcement'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    


    }
 //////..........

    public function addSchedule(ScheduleRequest $request)
        {

            $data=[];
        try{
            $data=$this->studentService->addSchedule($request->validated());
            return Response::Success($data['Schedule'],$data['message'],$data['code']) ;
        }

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

        }

        public function getSchedule(Request $request)
        {

            $data=[];
        try{
            $data=$this->studentService->getSchedule($request);
            return Response::Success($data['Schedule'],$data['message'],$data['code']) ;
        }

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

        }


}
