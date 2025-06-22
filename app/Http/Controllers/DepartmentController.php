<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Services\DepartmentService;
use App\Http\Responses\Response;
use PHPUnit\Event\Code\Throwable;

class DepartmentController extends Controller
{
    private DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService){
       $this->departmentService = $departmentService;
    }

    public function create(DepartmentRequest $request){

        $data=[];
     try{
         $data=$this->departmentService->create($request->validated());
         return Response::Success($data['department'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
    }

    public function update($department_id,DepartmentRequest $request){

        $data=[];
     try{
         $data=$this->departmentService->update($department_id,$request->validated());
         return Response::Success($data['department'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
   }

   public function delete($department_id){
        $data=[];
        try{
    
           $data=$this->departmentService->delete($department_id);
           return Response::Success($data['department'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function index(){
        $data=[];
        try{
    
           $data=$this->departmentService->index();
           return Response::Success($data['department'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

}
