<?php
namespace App\Repositories;
use App\Models\CourseRecord;
use Illuminate\Support\Facades\DB;

class CourseRecordRepository implements CourseRecordRepositoryInterface
{
    public function getLastRecordForStudentAndCourse($studentId, $courseName)
    {
        return CourseRecord::where('student_id', $studentId)
            ->whereHas('course', function ($q) use ($courseName) {
                $q->where('name', 'like', "%$courseName%");
            })
            ->latest('exam_date')
            ->first();
    }

  

}