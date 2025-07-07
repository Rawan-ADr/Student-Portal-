<?php
namespace App\Repositories;
use App\Models\CourseRecord;


class MarkRepository implements MarkRepositoryInterface
{

    public function getCourses($id){

        return    $courses = CourseRecord::where('student_id', $id)
                            ->with('course') 
                            ->get()
                            ->unique('course_id') 
                            ->values();
    }
    
    public function getMarks($studentId,$courseId){
        return  CourseRecord::where('student_id', $studentId)
        ->where('course_id', $courseId)
        ->with('mark') 
        ->get();

    }
}