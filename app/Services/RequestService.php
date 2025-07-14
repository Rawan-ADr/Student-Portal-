<?php


namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FieldRepositoryInterface;
use App\Repositories\RequestRepositoryInterface;




class RequestService
{

    private  $fieldRepository;
    private $requestRepository;

    public function __construct( FieldRepositoryInterface $fieldRepository,
    RequestRepositoryInterface $requestRepository ){
         $this->fieldRepository = $fieldRepository;
         $this->requestRepository=$requestRepository;
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
        
     }







