<?php


namespace App\Services;
use App\Imports\StudentMarksImport;
use App\Repositories\MarkRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CourseRecordResource;
use App\Http\Resources\StudentCourseResource;
use App\Repositories\RequestRepositoryInterface;
use App\Http\Resources\AllRequestResource;
use App\Http\Resources\DataRequestResource;
use App\Factories\RequestHandlerFactory;


class ExaminationService
{

    private  $markRepository;
    private  $requestRepository;

    public function __construct(MarkRepositoryInterface $markRepository,
                                RequestRepositoryInterface $requestRepository ){
        $this->markRepository = $markRepository;
        $this->requestRepository=$requestRepository;
        
     }


     public function importMarks($request)
     {
         Excel::import(new StudentMarksImport($this->markRepository), $request['file']);
     
         $message = "تم استيراد الملف بنجاح";
         $code = 200;
     
         return ['data' => '', 'message' => $message, 'code' => $code];
     }



public function getStudentCourses()
{
   $id=Auth::id();
   $courses=$this->markRepository->getCourses($id);
   if(!$courses){
    $message=" courses not found";
    $code=404; 
    return ['courses'=>$courses,'message'=>$message,'code'=>$code];

   } 
   else{
    $message="courses get successful";
    $code=200;
//
    return ['courses'=>$courses,'message'=>$message,'code'=>$code];
 }


}

public function getStudentMark($courseId)
{
   $studentId=Auth::id();
   $marks=$this->markRepository->getMarks($studentId,$courseId);
   if(!$marks){
    $message=" marks not found";
    $code=404; 
    return ['marks'=>$marks,'message'=>$message,'code'=>$code];

   } 
   else{
    $message="marks get successful";
    $code=200; 

    return ['marks'=>CourseRecordResource::collection($marks),'message'=>$message,'code'=>$code];

}

}

public function getExamRequests()
    {
        $requests=$this->requestRepository->getExamRequests();
        if(!$requests->isEmpty())
        {
            $message="requests get successfully";
            $code=200;
        }

        else
        {
            $message=" requests not found ";
            $code=404;
            return ['requests'=> $requests,'message'=>$message,'code'=>$code];
        }
        
        return ['requests'=> AllRequestResource::collection($requests),'message'=>$message,'code'=>$code];

    }

    public function getRequestData($id)
    {
        $request=$this->requestRepository->getRequestData($id);
        if($request)
        {
            $message="request get successfully";
            $code=200;
        }

        else
        {
            $message=" request not found ";
            $code=404;

            return ['request'=> $request,'message'=>$message,'code'=>$code];

        }
        
        return ['request'=>DataRequestResource::collection($request),'message'=>$message,'code'=>$code];

    }


    public function passingRequests($id){

        $step=$this->requestRepository->passingRequests($id);
        if($step)
        {
            if($step== 'done'){
                 $message="request completed successfully";
                $code=200;
            }
            else{

            $message="request move to the next step successfully";
            $code=200;
            }
        }

        else
        {
            $message=" request not found ";
            $code=404;
    
        }
        
        return ['step'=>$step,'message'=>$message,'code'=>$code];

    }


    public function processRequest($requestId)
{  
     /// لازم عدل
    $request = Request::with('document', 'student')->findOrFail($requestId);

    $handler = RequestHandlerFactory::make($request->document);
    $result = $handler->handle($request);
    $message=" تمت معالجة الطلب  ";
    $code=200;

    return  ['data' => $result, 'message' => $message,'code'=>$code];
}


}