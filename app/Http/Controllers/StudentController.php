<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\StudentService;

class StudentController extends Controller
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService){
       $this->studentService = $studentService;
    }


    public function login(Request $request)
    {

        $data=[];
     try{
         $data=$this->studentService->login($request);
         return Response::Success($data['token'],$data['message'],$data['code']) ;
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





}
