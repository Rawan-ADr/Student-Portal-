<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use App\Http\Responses\Response;
use PHPUnit\Event\Code\Throwable;


class EmployeeController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService){
       $this->employeeService = $employeeService;
    }

     public function create(EmployeeRequest $request){

        $data=[];
     try{
         $data=$this->employeeService->create($request->validated());
         return Response::Success($data['employee'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
    }

    public function update(UpdateEmployeeRequest $request,$employee_id){

        $data=[];
     try{
         $data=$this->employeeService->update($request->validated(),$employee_id);
         return Response::Success($data['employee'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
    }

    public function delete($employee_id){

        $data=[];
     try{
         $data=$this->employeeService->delete($employee_id);
         return Response::Success($data['employee'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
    }


    public function index(){

        $data=[];
     try{
         $data=$this->employeeService->index();
         return Response::Success($data['employee'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
    }


     

    
}
