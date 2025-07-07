<?php
namespace App\Services;
use App\Repositories\RequestRepositoryInterface;

class ReviewService
{
    private  $requestRepository;

    public function __construct(RequestRepositoryInterface $requestRepository )
    {
    
        $this->requestRepository=$requestRepository;
        
    }


    public function confirmReview($id)
    {
        $request=$this->requestRepository->confirmReview($id);
        if(!$request)
        {

            $message=" request not found ";
            $code=404;
          
        }

        else
        {
            $message="request confirm successfully";
            $code=200;
    
        }
        
        return ['request'=>$request,'message'=>$message,'code'=>$code];

    }

    public function rejecteRequest($id)
    {
        $request=$this->requestRepository->rejecteRequest($id);
        if(!$request)
        {

            $message=" request not found ";
            $code=404;
          
        }

        else
        {
            $message="request rejected successfully";
            $code=200;
    
        }
        
        return ['request'=>$request,'message'=>$message,'code'=>$code];

    }

    public function requestModification( $request,$id)
    {
        $request=$this->requestRepository->requestModification($request,$id);
        if(!$request)
        {

            $message=" request not found ";
            $code=404;
          
        }

        else
        {
            $message="done";
            $code=200;
    
        }
        
        return ['request'=>$request,'message'=>$message,'code'=>$code];
    }

}