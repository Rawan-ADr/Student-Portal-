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
use App\Repositories\ScheduleRepositoryInterface;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\RequestResource;
                     

class StudentService{

    private  $studentRepository;
    private $requestRepository;
    private  $fieldRepository;
    private  $attachmentRepository;
    private  $lectureRepository;
    private  $scheduleRepository;
    

    public function __construct(StudentRepositoryInterface $studentRepository,
                                 RequestRepositoryInterface $requestRepository,
                                 DocumentRepositoryInterface $documentRepository,
                                 FieldRepositoryInterface $fieldRepository,
                                 AttachmentRepositoryInterface $attachmentRepository,
                                 LectureRepositoryInterface $lectureRepository,
                                 ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->requestRepository=$requestRepository;
       $this->studentRepository = $studentRepository;
       $this->documentRepository = $documentRepository;
       $this->fieldRepository = $fieldRepository;
       $this->attachmentRepository = $attachmentRepository;
       $this->lectureRepository = $lectureRepository;
       $this->scheduleRepository = $scheduleRepository;
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

    public function getModRequest($id)
    {
        $requests=$this->requestRepository->getModRequest($id);
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

    public function getRequests($id)
    {
        $requests=$this->requestRepository->getRequests($id);
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
                return ['document'=> $document,'message'=>$message,'code'=>$code];

        
            }   
      
        return ['document'=> new DocumentResource($document),'message'=>$message,'code'=>$code];

    }


    public function sendRequest($request,$document_id)
    {
        $studentId=auth()->id();
        $Request=$this->requestRepository->create($studentId,$document_id);
        if($Request['code']==422){
            return ['request'=>$Request['request'],'message'=>$Request['message'],'code'=>$Request['code']];

        }
        else{
        $idd=$Request['request'];
        $fieldValue=$this->fieldRepository->addFieldValue($request,$idd);
        $this->attachmentRepository->addAttachmentValue($request,$idd);
        $message="The request has been sent ";
        $code=200;

        return ['request'=>$Request['request'],'message'=>$Request['message'],'code'=>$Request['code']];
        }
    }

    public function updateRequest($request,$request_id)
    {
        $studentId=auth()->id();
        $Request=$this->requestRepository-> getToUpdate($studentId,$request_id);
        if(!is_null($Request))
        {
            $fieldValue=$this->fieldRepository->updateFieldValue($request,$request_id);
            $this->attachmentRepository->updateAttachmentValue($request,$request_id);
            $message="The request update successfully ";
            $code=200;
        }
     
       else{
         $message="The request not found ";
        $code=404;}

        return ['request'=>$Request,'message'=>$message,'code'=>$code];

    }

    public function getRequest($id)
    {
        $request=$this->requestRepository->getRequest($id);
        if(!is_null($request))
        {


            $message="request get successfully";
            $code=200;
        }

        else
        {
            $message=" request not found ";
            $code=404;
            return ['request'=>$request,'message'=>$message,'code'=>$code];
    
        }
        
        return ['request'=>new RequestResource($request),'message'=>$message,'code'=>$code];

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

//////////////////////////

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

///////////////
    public function addAnnouncement($request){
        $Announcement =$this->lectureRepository->addAnnouncement($request);
        if(!$Announcement){
            $Announcement=null;
            $message="error...";
            $code=404;
        }
        $message="Announcement add successfully";
        $code=200; 

        return ['Announcement'=>$Announcement,'message'=>$message,'code'=>$code];
    }

    ///////////////
    public function updateAnnouncement($request,$id){
        $Announcement =$this->lectureRepository->updateAnnouncement($request,$id);
        if(!$Announcement){
            $Announcement=null;
            $message="not found";
            $code=404;
        }
        else{
        $message="Announcement updated successfully";
        $code=200; }

        return ['Announcement'=>$Announcement,'message'=>$message,'code'=>$code];
    }

    ///////////////
    public function deleteAnnouncement($id){
        $Announcement =$this->lectureRepository->deleteAnnouncement($id);
        if(!$Announcement){
            $Announcement=null;
            $message="not found";
            $code=404;
        }
        else{
        $message="Announcement deleted successfully";
        $code=200; }

        return ['Announcement'=>$Announcement,'message'=>$message,'code'=>$code];
    }


    
    public function getAnnouncement()
    {
        $Announcement=$this->lectureRepository->getAnnouncement();
        if(!$Announcement->isEmpty()){
            $message="This is all Announcement";
            $code=200;   
        }

        else {
            $Announcement=null;
            $message="not found";
            $code=404;
        }

        return ['Announcement'=>$Announcement,'message'=>$message,'code'=>$code];



    }

    public function addSchedule($request){
        $Schedule=$this->scheduleRepository->add($request);
        if(!$Schedule){
            $message="يوجد تضارب في الجدول مع محاضرة أخرى في نفس اليوم والسنة والفصل";
            $code=404;
            return ['Schedule'=>$Schedule,'message'=>$message,'code'=>$code];

        }
        else{
        $message="Lecture Time add successfully";
        $code=200; 

        return ['Schedule'=>$Schedule,'message'=>$message,'code'=>$code];
        }
    }

    
    public function getSchedule($request){
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);
        $schedule=$this->scheduleRepository->get($request);
        if(!$schedule){
            $Schedule=null;
            $message="error...";
            $code=404;
        }
        else{
           $Schedule=$schedule->map(function ($lectures, $dayName) {
            return [
                'day' => $dayName,
                'lectures' => $lectures->map(function ($lecture) {
                    return [
                        'course_name' => $lecture->course->name,
                        'start_time' => $lecture->start_time,
                        'end_time' => $lecture->end_time,
                        'type' => $lecture->type,
                        'doctor_name'=>$lecture->doctor_name 
                    ];
                })->values()
            ];
        })->values();

        $message="Schedule get successfully";
        $code=200;
        } 

        return ['Schedule'=>$Schedule,'message'=>$message,'code'=>$code];

    }
   
}