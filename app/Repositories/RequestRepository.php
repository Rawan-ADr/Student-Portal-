<?php
namespace App\Repositories;
use App\Models\Request;

class RequestRepository implements RequestRepositoryInterface
{

    public function getReceivedRequest($id){
        return Request::where('student_id', $id)->where('status', 'done')->get() ;

    }
    public function getRequest($id){
        return Request::where('student_id', $id)->where('status','!=', 'done')->get() ;

    }
}