<?php


namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DocumentResource;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\RequestRepositoryInterface;                      
use App\Repositories\DocumentRepositoryInterface; 
use App\Repositories\FieldRepositoryInterface;
use App\Repositories\AttachmentRepositoryInterface;                     
use App\Repositories\LectureRepositoryInterface;
                     

class StudentService{

    private  $studentRepository;
    private $requestRepository;
    private  $fieldRepository;
    private  $attachmentRepository;
    private  $lectureRepository;
    

    public function __construct(StudentRepositoryInterface $studentRepository,
                                 RequestRepositoryInterface $requestRepository,
                                 DocumentRepositoryInterface $documentRepository,
                                 FieldRepositoryInterface $fieldRepository,
                                 AttachmentRepositoryInterface $attachmentRepository,
                                 LectureRepositoryInterface $lectureRepository)
    {
        $this->requestRepository=$requestRepository;
       $this->studentRepository = $studentRepository;
       $this->documentRepository = $documentRepository;
       $this->fieldRepository = $fieldRepository;
       $this->attachmentRepository = $attachmentRepository;
       $this->lectureRepository = $lectureRepository;
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
        $requests=$this->requestRepository->getReceivedRequest($id);
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
        $requests=$this->requestRepository->getRequest($id);
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


    public function sendRequest($request,$document_id)
    {
        $studentId=auth()->id();
        $Request=$this->requestRepository->create($studentId,$document_id);
        $fieldValue=$this->fieldRepository->addFieldValue($request,$Request);
        $this->attachmentRepository->addAttachmentValue($request,$Request);
        $message="The request has been sent ";
        $code=200;

        return ['request'=>$Request,'message'=>$message,'code'=>$code];

    }


    public function getLecture($request)
    {
        $lectures=$this->lectureRepository->get($request);
        if($lectures != null){
            $message="This is all lecture";
            $code=200;   
        }
        else{
            $lectures=null;
            $message="not found";
            $code=404;
        }

        return ['lectures'=>$lectures,'message'=>$message,'code'=>$code];



    }

    public function getCourse($request)
    {
        $courses=$this->lectureRepository->getCourse($request);
        if(!$courses->isEmpty()){
            $message="This is all courses";
            $code=200;   
        }
        else{
            $courses=null;
            $message="not found";
            $code=404;
        }

        return ['courses'=>$courses,'message'=>$message,'code'=>$code];



    }

    public function getYears()
    {
        $Years=$this->lectureRepository->getYear();
        if(!$Years->isEmpty()){
            $message="This is all Years";
            $code=200;   
        }
        else{
            $Years=null;
            $message="not found";
            $code=404;
        }

        return ['Years'=>$Years,'message'=>$message,'code'=>$code];

    
    }


    public function getSemester()
    {
        $semester=$this->lectureRepository->getSemester();
        if(!$semester->isEmpty()){
            $message="This is all Years";
            $code=200;   
        }
        else{
            $semester=null;
            $message="not found";
            $code=404;
        }

        return ['semester'=>$semester,'message'=>$message,'code'=>$code];

    }



    public function addLecture($request){
        $lecture =$this->lectureRepository->add($request);
        if(!$lecture){
            $lecture=null;
            $message="error...";
            $code=404;
        }
        $message="lecture add successfully";
        $code=200; 

        return ['lecture'=>$lecture,'message'=>$message,'code'=>$code];
    }
   
}