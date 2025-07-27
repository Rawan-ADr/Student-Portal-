<?php
namespace App\Repositories;
use App\Models\CourseRecord;
use App\Models\StudentFile;
use App\Models\Mark;
use App\Models\Semester;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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


 

function checkPromotionStatus($studentId)
{
    $studentFile = StudentFile::where('student_id', $studentId)->first();
    if (!$studentFile) return 'Student file not found';

    // احضار كل آخر محاولة لكل مادة
    $failedSubjectsCount = DB::table('marks as m')
        ->join('course_records as cr', 'm.course_record_id', '=', 'cr.id')
        ->where('cr.student_id', $studentId)
        ->select('cr.course_id', DB::raw('MAX(m.id) as latest_mark_id'))
        ->groupBy('cr.course_id')
        ->get()
        ->pluck('latest_mark_id')
        ->toArray();

    // تحقق من حالة كل محاولة أخيرة: هل هي "fail"
    $carriedCoursesCount = Mark::whereIn('id', $failedSubjectsCount)
        ->where('status', 'fail')
        ->count();

    $promoted = $carriedCoursesCount <= 4;

    // تحديث حالة الترفع
    

    if ($promoted) {
        $today = Carbon::now();
        $currentSemester = Semester::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();
        $nextYear = Year::where('id', '>', $studentFile->year_id)->orderBy('id')->first();
        if ($nextYear) {
            $studentFile->year_id = $nextYear->id;
            $studentFile->semester_id = $currentSemester->id;
            $studentFile->academic_year = Carbon::now();
            $studentFile->status = "promoted";
        }
        else{
            $studentFile->year_id = $nextYear->id;
            $studentFile->semester_id = $currentSemester->id;
            $studentFile->academic_year = Carbon::now();
            $studentFile->status = "Graduated";
        }
    }

    $studentFile->save();

    return $promoted ? 'Student promoted' : 'Student not promoted';
}




    public function TheoreticalMark($courseRecordId, $newMark): void
    {
        $mark = Mark::where('course_record_id', $courseRecordId)->first();

        if ($mark) {
              if (!is_null($newMark)) {
            $mark->theoretical_mark = $newMark;
        }

        // احسب المجموع بناءً على القيم الحالية
        $theoretical = $mark->theoretical_mark ?? 0;
        $practical = $mark->practical_mark ?? 0;

        $mark->total_mark = $theoretical + $practical;
        $mark->status = $mark->total_mark >= 50 ? 'pass' : 'fail';

        $mark->save();
    }
}

}