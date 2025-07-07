<?php

namespace App\Repositories;




    interface MarkRepositoryInterface
{
    public function getCourses($id);
    public function getMarks($studentId,$courseId); 
}
