<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\StudentService;
use App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService){
       $this->studentService = $studentService;
    }


    public function login(StudentRequest $request)
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





}
