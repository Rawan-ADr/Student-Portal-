<?php

namespace App\Imports;



use App\Models\Student;
use App\Models\Course;
use App\Models\CourseRecord;
use App\Models\Mark;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentMarksImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $student = Student::where('university_number', $row['university_number'])->first();
       // $course = Course::where('name', $row['course_name'])->first();

        if ($student) {
            // نسجل محاولة جديدة للمادة
            $courseRecord = CourseRecord::create([
                'student_id' => $student->id,
                'course_id' =>request('course_id'),
                'semester_id' => request('semester_id'), // تستلميها مع الطلب
                'exam_date' => now(),
            ]);

            // نضيف العلامات
            Mark::create([
                'course_record_id' => $courseRecord->id,
                'practical_mark' => $row['practical_mark'],
                'theoretical_mark' => $row['theoretical_mark'],
                'total_mark' => $row['total_mark'],
                'status' => $row['total_mark'] >= 50 ? 'pass' : 'fail', // تعديل حسب نظامك
            ]);
        }
    }
}

