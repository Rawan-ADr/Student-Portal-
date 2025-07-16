<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkUpdateRequest;
use App\Services\RequestService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\Response;

class RequestController extends Controller
{
      private RequestService $requestService;

    public function __construct(RequestService $requestService){
       $this->requestService = $requestService;
    }

    public function updatePracticalMark(MarkUpdateRequest $request)
    {
         $data=[];
     try{
        $data= $this->requestService->updateMarkAndJustification($request->validated());
         return Response::Success($data['data'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
    }

      public function updateTheoreticalMark(MarkUpdateRequest $request)
    {
        $data=[];
     try{
        $data= $this->requestService->updateTheoreticalMark($request->validated());
         return Response::Success($data['data'],$data['message']) ;
     }

     catch (Throwable $th){
         $message=$th->getmessage();
         return Response::Error($data,$message);

     }
    }
}
