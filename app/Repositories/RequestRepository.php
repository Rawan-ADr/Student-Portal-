<?php
namespace App\Repositories;
use App\Models\Request;
use Carbon\Carbon;

class RequestRepository implements RequestRepositoryInterface
{

    public function getReceivedRequest($id){
        return Request::where('student_id', $id)->where('status', 'done')->get() ;

    }
    public function getRequests($id){
        return Request::where('student_id', $id)->where('status','!=', 'done')->get() ;

    }

    public function getModRequest($id){
        return Request::where('student_id', $id)->where('status', 'required modification')->get() ;

    }

    public function create($studentId,$document_id){
      $request = Request::create([
            'date'=> Carbon::now(),
            'status'=>'under review',
            'point'=>'first',
            'student_id'=>$studentId,
            'document_id'=>$document_id
        ]);

        $request->save();

        return $request;
    }

    

    public function getToUpdate($studentId,$request_id){
        $studentRequest=Request::where('student_id', $studentId)->where('id', $request_id)->first() ;
       if (!$studentRequest) {
        return null;
    }
    $studentRequest->update([
        'status' => 'under review',
        'modifications' =>null,
     ]);

     $studentRequest->save();
    return $studentRequest;

    }
    public function getRequest($id){
        $req=Request::find($id);
        if(!$req){
            return null; 
        }
        $Request = Request::with(['fieldValues.field', 'attachmentValues.attachment'])->find($id);


    
        if (!$Request) {
            return null;
        }

        return $Request;

    }

}