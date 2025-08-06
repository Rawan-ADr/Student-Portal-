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
/////////////////
   

  

   
//
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

    public function getAllStudent(){
         $data=[];
     try{
         $data=$this->studentService->getAllStudent();
         return Response::Success($data['students'],$data['message']) ;
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

    public function getModRequest($id)
    {

        $data=[];
     try{
         $data=$this->studentService->getModRequest($id);
         return Response::Success($data['requests'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }


    
    public function getRequests($id)
    {

        $data=[];
     try{
         $data=$this->studentService->getRequests($id);
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
         return Response::Success($data['request'],$data['message'],$data['code']) ;
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
           return response()->json([
            'request' => $data['request'],
            'message' => $data['message'],
            'code' => $data['code'],
            'redirect_url' => $data['redirect_url'] ?? null, 
        ], $data['code']);
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function updateRequest(RequestRequest $request,$document_id)
    {

        $data=[];
     try{
         $data=$this->studentService->updateRequest($request,$document_id);
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

    public function updateAnnouncement(Request $request,$id)
    {

        $data=[];
     try{
         $data=$this->studentService->updateAnnouncement($request,$id);
         return Response::Success($data['Announcement'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function deleteAnnouncement($id)
    {

        $data=[];
     try{
         $data=$this->studentService->deleteAnnouncement($id);
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
    public function getAnnouncementByUserId()
    {

        $data=[];
     try{
         $data=$this->studentService->getAnnouncementByUserId();
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
