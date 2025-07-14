<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\UserService;
use PHPUnit\Event\Code\Throwable;
use App\Http\Requests\AssignPermissionsRequest;
use App\Http\Requests\AssignRoleRequest;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService){
       $this->userService = $userService;
    }

    public function login(Request $request){

        $data=[];
     try{
         $data=$this->userService->login($request);
         return Response::Success($data['user'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
 }


     public function logout(){

        $data=[];
       try{
         $data=$this->userService->logout();
         return Response::Success($data['user'],$data['message'],$data['code']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }
        }

        public function indexRole(){
             $data=[];
       try{
         $data=$this->userService->indexRole();
         return Response::Success($data['role'],$data['message']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }


        }

        public function indexPermissions(){
             $data=[];
       try{
         $data=$this->userService->indexPermissions();
         return Response::Success($data['permission'],$data['message']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }


        }

        public function assignPermissions(AssignPermissionsRequest $request){

            $data=[];
       try{
         $data=$this->userService->assignPermissions($request->validated());
         return Response::Success($data['result'],$data['message']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }
        }  

        public function assignRole(AssignRoleRequest $request){
           $data=[];
       try{
         $data=$this->userService->assignRole($request->validated());
         return Response::Success($data['result'],$data['message']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }

        }
         public function indexUsers(){
             $data=[];
       try{
         $data=$this->userService->indexUsers();
         return Response::Success($data['users'],$data['message']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }


        }

        public function indexUserByToken(){
          $data=[];
       try{
         $data=$this->userService->indexUserByToken();
         return Response::Success($data['user'],$data['message']) ;
        }

      catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

        }
        }
        

    





}
