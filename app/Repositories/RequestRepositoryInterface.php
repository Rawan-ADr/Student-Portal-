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
    public function find($id);
    public function getCourseNameFromRequest($requestId): ?string;
    public function indexContent($id);

}
