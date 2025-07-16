<?php

namespace App\Repositories;

interface CourseRecordRepositoryInterface{

 public function getLastRecordForStudentAndCourse($studentId, $courseName);


}
