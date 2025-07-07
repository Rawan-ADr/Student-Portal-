<?php

namespace App\Repositories;

interface RequestRepositoryInterface{

    public function getReceivedRequest($id);
    public function getRequest($id);
    public function create($studentId,$documentId);
    public function getExamRequests();
    public function passingRequests($requestId);
    public function requestModification($request,$id);
    public function confirmReview($id);

}
