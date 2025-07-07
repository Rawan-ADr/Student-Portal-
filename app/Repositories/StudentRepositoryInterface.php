<?php

namespace App\Repositories;

interface StudentRepositoryInterface{
    public function findByNationalNumber(string $nationalNumber);
    public function find($id);
    public function createStudent($request);
    public function createStudentRecord($request);
    public function addNotes($request,$id);
    public function getStudentRecords($id);
    
}