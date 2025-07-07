<?php

namespace App\Repositories;
use App\Models\Lecture;


    interface LectureRepositoryInterface
{
    public function get($request);
    public function getYear();
    public function getSemester();
    public function add($request);
    public function getCourse($request);
    public function addAnnouncement($request);
    public function deleteAnnouncement($id);
    public function updateAnnouncement($request,$id);
    public function getAnnouncement();

}