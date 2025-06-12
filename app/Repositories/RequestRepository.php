<?php
namespace App\Repositories;
use App\Models\Request;
use Carbon\Carbon;

class RequestRepository implements RequestRepositoryInterface
{

    public function getReceivedRequest($id){
        return Request::where('student_id', $id)->where('status', 'done')->get() ;

    }
    public function getRequest($id){
        return Request::where('student_id', $id)->where('status','!=', 'done')->get() ;

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
}