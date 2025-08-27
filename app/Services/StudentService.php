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
use App\Http\Resources\RequestResultResource;
use App\Http\Resources\AllReqResource;
use Illuminate\Support\Facades\DB;
                     

class StudentService{

    private  $studentRepository;
    private $requestRepository;
    private  $fieldRepository;
    private  $attachmentRepository;
    private  $lectureRepository;
    private  $scheduleRepository;
    private  $documentRepository;
    
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

    public function getAllStudent(){

        $student=$this->studentRepository->all();
        if(!is_null($student))
        {
            $message="students get successfully";
        }

        else
        {
            $message=" students not found ";
    
        }
        
        return ['students'=>$student,'message'=>$message];
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
        
        return ['requests'=>AllReqResource::collection($requests),'message'=>$message,'code'=>$code];

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
        
        return ['requests'=>AllReqResource::collection($requests),'message'=>$message,'code'=>$code];

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
        
        return ['requests'=>AllReqResource::collection($requests),'message'=>$message,'code'=>$code];

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


    public function sendRequest($request, $document_id)
    {
       $studentId = auth()->id();
    $student = $this->studentRepository->find($studentId);

    if (!$student) {
        return ['request' => null, 'message' => 'Student not found', 'code' => 404];
    }

    $document = $this->documentRepository->find($document_id);
    if (!$document) {
        return ['request' => null, 'message' => 'Document not found', 'code' => 404];
    }

    $fee = $document->fee;

    DB::beginTransaction();
    try {
        // إنشاء الطلب بحالة pending_payment
        $Request = $this->requestRepository->create($studentId, $document_id);

        if ($Request['code'] == 422) {
            DB::rollBack();
            return ['request' => $Request['request'], 'message' => $Request['message'], 'code' => $Request['code']];
        }

        $idd = $Request['request'];
        $id = $Request['request']->id;
        

        // إدخال الحقول والمرفقات
        $this->fieldRepository->addFieldValue($request, $idd);
        $this->attachmentRepository->addAttachmentValue($request, $idd);

        DB::commit();

        // إنشاء جلسة Stripe
        $session = app(\App\Services\StripeService::class)
                        ->createCheckoutSession($fee, $studentId, $id);

        return [
            'request' => $idd,
            'redirect_url' => $session->url,
            'message' => 'Request created. Please complete the payment.',
            'code' => 200
        ];
    } catch (\Exception $e) {
        DB::rollBack();
        return ['request' => null, 'message' => 'An error occurred: ' . $e->getMessage(), 'code' => 500];
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


    public function getRequestResult($request_id){

        $request=$this->requestRepository->getRequestResult($request_id);
        if(!is_null($request))
        {


            $message="request get successfully";
            $code=200;
        }

        else
        {
            $message=" request not found or not completed ";
            $code=404;
            return ['requestResult'=>$request,'message'=>$message,'code'=>$code];
    
        }
        
        return ['requestResult'=>new RequestResultResource($request),'message'=>$message,'code'=>$code];
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

    public function addLecture($request)
{
    $user = auth()->user();

    // التحقق من أن المستخدم يملك دور "professor"
    if (!$user->hasRole('professor')) {
        return [
            'lecture' => null,
            'message' => 'Access denied. Only professors can add lectures.',
            'code' => 403
        ];
    }
    $employee = $user->employee;
        $professor = $employee ? $employee->professor : null;

        if (!$professor) {
            return [
                'lecture' => null,
                'message' => 'Professor profile not found.',
                'code' => 404,
            ];
        }

        $courseId = $request->input('course_id');

        //  التحقق من ارتباطه بالمادة
        if (!$this->lectureRepository->professorTeachesCourse($professor->id, $courseId)) {
            return [
                'lecture' => null,
                'message' => 'You are not assigned to this course.',
                'code' => 403,
            ];
        }

    $lecture = $this->lectureRepository->add($request);

    if (!$lecture) {
        return [
            'lecture' => null,
            'message' => 'Error adding lecture.',
            'code' => 404
        ];
    }

    return [
        'lecture' => $lecture,
        'message' => 'Lecture added successfully.',
        'code' => 200
    ];
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
        if($Announcement==0){
            $Announcement=null;
            $message="you can not do it";
            $code=403;  
        }
        else{
        if(!$Announcement){
            $Announcement=null;
            $message="not found";
            $code=404;
        }
        else{
        $message="Announcement updated successfully";
        $code=200; }
        }
        return ['Announcement'=>$Announcement,'message'=>$message,'code'=>$code];
    }

    ///////////////
    public function deleteAnnouncement($id){
        $Announcement =$this->lectureRepository->deleteAnnouncement($id);
        if($Announcement==0){
            $Announcement=null;
            $message="you can not do it";
            $code=403;  
        }
        else{
        if(!$Announcement){
            $Announcement=null;
            $message="not found";
            $code=404;
        }
        else{
        $message="Announcement deleted successfully";
        $code=200; }
        }
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
    public function getAnnouncementByUserId()
    {
        $Announcement=$this->lectureRepository->getAnnouncementByUserId();
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

     public function getAnnouncementById($id){
        $Announcement=$this->lectureRepository->getAnnouncementById($id);
        if(!$Announcement->isEmpty()){
            $message=" Announcement indexed successfully";
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

    $schedules = $this->scheduleRepository->get($request);

    if($schedules->isEmpty()){
        $Schedule = null;
        $message = "Schedule not found";
        $code = 404;
    } else {
        $Schedule = $schedules->groupBy(function($lecture){
            // إذا الاختصاص null، نضعه تحت "بدون اختصاص"
            return $lecture->specialization ?? 'بدون اختصاص';
        })->map(function($specGroup, $specName){
            return [
                'specialization' => $specName,
                'days' => $specGroup->groupBy(function($lecture){
                    return $lecture->day->name;
                })->map(function($dayLectures, $dayName){
                    return [
                        'day' => $dayName,
                        'lectures' => $dayLectures->map(function($lecture){
                            return [
                                'course_name' => $lecture->course->name,
                                'start_time' => $lecture->start_time,
                                'end_time' => $lecture->end_time,
                                'type' => $lecture->type,
                                'doctor_name' => $lecture->doctor_name
                            ];
                        })->values()
                    ];
                })->values()
            ];
        })->values();

        $message = "Schedule get successfully";
        $code = 200;
    }

    return ['Schedule' => $Schedule, 'message' => $message, 'code' => $code];

    }

     
   
}