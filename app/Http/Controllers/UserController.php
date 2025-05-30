<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\UserService;
use PHPUnit\Event\Code\Throwable;

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





}
