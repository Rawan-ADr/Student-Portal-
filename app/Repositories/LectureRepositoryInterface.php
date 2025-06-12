<?php

namespace App\Repositories;
use App\Models\Lecture;


    interface LectureRepositoryInterface
{
    public function get($request);
    public function getYear();
    public function getSemester();
    public function add($request);
}