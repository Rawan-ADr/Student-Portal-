<?php


namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Repositories\FieldRepositoryInterface;
use App\Repositories\RequestRepositoryInterface;
use App\Repositories\MarkRepositoryInterface;
use App\Repositories\CourseRecordRepositoryInterface;




class RequestService
{

    private  $fieldRepository;
    private $requestRepository;
    private $courseRecordRepository;
    private $markRepository;

    public function __construct( FieldRepositoryInterface $fieldRepository,
    RequestRepositoryInterface $requestRepository,MarkRepositoryInterface $markRepository,
     CourseRecordRepositoryInterface $courseRecordRepository){
         $this->fieldRepository = $fieldRepository;
         $this->requestRepository=$requestRepository;
         $this->courseRecordRepository=$courseRecordRepository;
         $this->markRepository=$markRepository;
    }

           public function updateMarkAndJustification(array $data)
    {

        $user = auth()->user();
    if ($user->hasRole('professor')) {
        $requestId = $data['request_id'];

        $markField = $this->fieldRepository->getByName('الدرجة الصحيحة');
        $justificationField = $this->fieldRepository->getByName('تبرير النتيجة');

        if (array_key_exists('mark', $data)) {
            $this->fieldRepository->updateOrCreate($requestId, $markField->id, $data['mark']);
        }

        $this->fieldRepository->updateOrCreate($requestId, $justificationField->id, $data['justification']);
        $this->requestRepository->passingRequests($requestId);

        $message="result sending successfully";
        return ['data'=>null,'message'=>$message];
    }
    else{
        $message="you can not do this";
        return ['data'=>null,'message'=>$message];
    }


    }
    

     public function updateTheoreticalMark(array $data)
    {

        $user = auth()->user();
    if ($user->hasRole('committee')) {
        $requestId = $data['request_id'];

        $markField = $this->fieldRepository->getByName('الدرجة الصحيحة');
        $justificationField = $this->fieldRepository->getByName('تبرير النتيجة');

        if (array_key_exists('mark', $data)) {
            $this->fieldRepository->updateOrCreate($requestId, $markField->id, $data['mark']);
        }

        $this->fieldRepository->updateOrCreate($requestId, $justificationField->id, $data['justification']);
        $request = $this->requestRepository->find($requestId);
        $studentId = $request->student_id;

        $courseName = $this->requestRepository->getCourseNameFromRequest($requestId);
        if (!$courseName) {
            $message="Course name not found in request fields.";
        }

        $record = $this->courseRecordRepository->getLastRecordForStudentAndCourse($studentId, $courseName);
        if (!$record) {
            $message="No course record found for this student and course.";
        }

        $this->markRepository->TheoreticalMark($record->id, $data['mark']);
        $this->requestRepository->passingRequests($requestId);

        $message="result sending successfully";
        return ['data'=>null,'message'=>$message];
    }
    else{
        $message="you can not do this";
        return ['data'=>null,'message'=>$message];
    }


    }

    public function indexContent($request_id){

         $user = auth()->user();
       if ($user->hasRole('deanship office')){
                $request = $this->requestRepository->find($request_id);
                if(is_null($request)){
                     $message="request not found";
                return ['request'=>null,'message'=>$message];
                }
               $content = $this->requestRepository->indexContent($request_id);
               $message="request indexed successfully";
              return ['request'=>$content,'message'=>$message];
       }
        else{
        $message="you can not do this";
        return ['request'=>null,'message'=>$message];
    }
    }

    public function indexLogs(){
        if ( Auth::user()->hasRole('admin')) {
            $requestLogs = $this->requestRepository->indexLogs();
                if(is_null($requestLogs)){
                     $message="requestLogs not found";
                return ['requestLogs'=>null,'message'=>$message];
                }
               $message="requestLogs indexed successfully";
              return ['requestLogs'=>$requestLogs,'message'=>$message];
       }
        else{
        $message="you can not do this";
        return ['requestLogs'=>null,'message'=>$message];
    }

        }

        public function getNameForRequest($request_id){
            if ( Auth::user()->hasRole('admin')) {
            $requestName = $this->requestRepository->getNameForRequest($request_id);
                if(is_null($requestName)){
                     $message="request not found";
                return ['requestName'=>null,'message'=>$message];
                }
               $message="requestName indexed successfully";
              return ['requestName'=>$requestName,'message'=>$message];
       }
        else{
        $message="you can not do this";
        return ['requestName'=>null,'message'=>$message];
    }
        }

        public function getAllRequestNames(){
            if ( Auth::user()->hasRole('admin')) {
            return $this->requestRepository->getAllRequestNames();
        }
        else{
            return null;
        }
    }
        
     





}

