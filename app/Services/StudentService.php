<?php


namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DocumentResource;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\RequestRepositoryInterface;                      
use App\Repositories\DocumentRepositoryInterface;                      

class StudentService{

    private  $studentRepository;
    private $requestRepository;
    

    public function __construct(StudentRepositoryInterface $studentRepository,
                                 RequestRepositoryInterface $requestRepository,
                                 DocumentRepositoryInterface $documentRepository)
    {
        $this->rerequestRepository=$requestRepository;
       $this->studentRepository = $studentRepository;
       $this->documentRepository = $documentRepository;
    }

    public function login($request){
        $student = $this->studentRepository->findByNationalNumber($request['national_number']);
        if(!is_null($student)){
             
            $student['token']=$student->createToken("token")->plainTextToken;
                $message=" logged in successfully ";
                $code=200;
            
        }
        else{
              // $token=null;
               $message=" student not found ";
               $code=404;
        }
        return ['student'=>$student,'message'=>$message,'code'=>$code];
    }


    public function logout(){
        $student=$this->studentRepository->find(Auth::id());
        if(!is_null($student)){
            Auth::user()->currentAccessToken()->delete();
            $message=" logged out successfully ";
            $code=200;
        }
        else{
            $message=" invalid token ";
            $code=404;
        }
        return ['student'=>$student,'message'=>$message,'code'=>$code];
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
        if($requests->isEmpty())
        {

            $message=" requests not found ";
            $code=404;
          
        }

        else
        {
            $message="requests get successfully";
            $code=200;
    
        }
        
        return ['requests'=>$requests,'message'=>$message,'code'=>$code];

    }

    public function getRequest($id)
    {
        $requests=$this->rerequestRepository->getRequest($id);
        if(!$requests->isEmpty())
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

    public function getDocument($id){
       
            $document=$this->documentRepository->findall($id);
            
            if(!is_null($document))
            {
                $message="document get successfully";
                $code=200;
            }
        
            else
            {
                $message=" document not found ";
                $code=404;
        
            }   
      
        return ['document'=> new DocumentResource($document),'message'=>$message,'code'=>$code];

    }


   
}