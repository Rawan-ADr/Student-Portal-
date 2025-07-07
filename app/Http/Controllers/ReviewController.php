<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\ReviewService;


class ReviewController extends Controller
{
  
    private ReviewService $ReviewService;

    public function __construct(ReviewService $ReviewService){
       $this->ReviewService = $ReviewService;
    }
  
    public function confirmReview($id)
    {

        $data=[];
     try{
         $data=$this->ReviewService->confirmReview($id);
         return Response::Success($data['request'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }

    public function rejecteRequest($id)
    {

        $data=[];
     try{
         $data=$this->ReviewService->rejecteRequest($id);
         return Response::Success($data['request'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }


    public function requestModification(Request $request,$id)
    {

        $data=[];
     try{
         $data=$this->ReviewService->requestModification($request,$id);
         return Response::Success($data['request'],$data['message'],$data['code']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }

    }
}
