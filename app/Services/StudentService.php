<?php


namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\RequestRepositoryInterface;                      

class StudentService{

    private  $studentRepository;
    private $requestRepository;
    

    public function __construct(StudentRepositoryInterface $studentRepository,
                                 RequestRepositoryInterface $requestRepository)
    {
        $this->rerequestRepository=$requestRepository;
       $this->studentRepository = $studentRepository;
    }

    public function login($request){
        $student = $this->studentRepository->findByNationalNumber($request->national_number);
        if(!is_null($student)){
             
                $token=$student->createToken("token")->plainTextToken;
                $message=" logged in successfully ";
                $code=200;
            
        }
        else{
               $token=null;
               $message=" student not found ";
               $code=404;
        }
        return ['token'=>$token,'message'=>$message,'code'=>$code];
    }


    public function getStudent($id)
    {
        $student=$this->studentRepository->find($id);
        if(!is_null($student))
        {
            $message="student get successfully";
            $code=200;
        }

        else
        {
            $message=" student not found ";
            $code=404;
    
        }
        
        return ['student'=>$student,'message'=>$message,'code'=>$code];

    }

    
    public function getReceivedRequest($id)
    {
        $requests=$this->rerequestRepository->getReceivedRequest($id);
        if(!is_null($requests))
        {


            $message="requests get successfully";
            $code=200;
        }

        else
        {
            $message=" requests not found ";
            $code=404;
    
        }
        
        return ['requests'=>$requests,'message'=>$message,'code'=>$code];

    }

    public function getRequest($id)
    {
        $requests=$this->rerequestRepository->getRequest($id);
        if(!is_null($requests))
        {


            $message="requests get successfully";
            $code=200;
        }

        else
        {
            $message=" requests not found ";
            $code=404;
    
        }
        
        return ['requests'=>$requests,'message'=>$message,'code'=>$code];

    }


   
}