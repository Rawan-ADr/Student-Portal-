<?php
namespace App\Services\RequestHandlers;

use App\Models\Request;
use App\Models\Student;
use App\Models\StudentFile;
use App\Models\Field;
use App\Models\FieldValue;
use App\Models\Year;
use App\Models\Semester;
use App\Models\Document;
use App\Models\StudentRecord;
use App\Models\CourseRecord;
use Illuminate\Support\Facades\DB;

class UniversityLifeHandler implements RequestHandlerInterface
{
    public function handle($request)
    {
        $studentId = $request->student_id;

        $student = Student::find($studentId);
        $studentFile = StudentFile::where('student_id', $studentId)->first();
        $semester_cycle=Semester::find( $studentFile->semester_id);

          // استرجاع بيانات حياة الطالب الجامعية لكل سنة
          $lifeTableData = $this->getAcademicLifeRows($student->id,$request);

          $field = Field::where('name', 'academic_life_table')->first();
          // حفظها داخل حقل الجدول في الداتا
          FieldValue::Create([
              'request_id' => $request->id,
              'field_id' => $field->id,
              'value' => json_encode($lifeTableData, JSON_UNESCAPED_UNICODE),
          ]);

          
         
      
          if($studentFile->status==='متخرج'){
            $graduationYear=$studentFile->academic_year;
            $semesterName=$semester_cycle->name;
        }
        else{
            $graduationYear="/";
            $semesterName="/"; 
        }
  
   
        $yearsInfo = $this->calculateUsedAndRemainingYears($studentId);
        $fieldData = [
            'عدد سنوات التسجيل المتبقية' => $yearsInfo,
            'تخرج الطالب في العام' => $graduationYear,
            'الدورة' =>  $semesterName,
        ];


        foreach ($fieldData as $fieldName => $value) {
            $field = Field::where('name', $fieldName)->first();
            if ($field && $value !== null) {
                FieldValue::create([
                    'request_id' => $request->id,
                    'field_id' => $field->id,
                    'value' => $value,
                ]);
            }
        }




        $fieldValues = FieldValue::where('request_id', $request->id)->with('field')->get();
        $document=Document::find(  $request->document_id);;

        // // تجهيز مصفوفة القيم للاستبدال
        $replacements = [

        ];
        $contentTemplate = $document->content;

        foreach ($fieldValues as $fieldValue) {
            $replacements['{{' . $fieldValue->field->name . '}}'] = $fieldValue->value;
        }
    
        // استبدال المتغيرات بالمحتوى
        $finalContent = strtr($contentTemplate, $replacements);
    

        // حفظ النتيجة في الطلب (يفضل إضافة عمود جديد مثل filled_content)
        $request->content_value = $finalContent;
        $request->save();

        return $request;
    }


    protected function getAcademicLifeRows($studentId,$request)
    {
        // استعلام بيانات كل سنة دراسية من جدول student_years (مثلًا)
        $studentRecords = StudentRecord::with(['year',  'student'])->where('student_id', $studentId)->get();

        // جلب كل سجلات المواد التي قدمها الطالب
        $courseRecords = CourseRecord::where('student_id', $studentId)->get();




        function getAcademicYearFromDate($examDate)
        {
            $year = (int)substr($examDate, 0, 4);
            $month = (int)substr($examDate, 5, 2);
        
            if ($month < 7) {
                // قبل تموز => تابع للعام الدراسي السابق
                return ($year - 1) . '-' . $year;
            } else {
                // تموز أو بعد => تابع للعام الدراسي الحالي
                return $year . '-' . ($year + 1);
            }
        }

        $rows = [];

        foreach ($studentRecords as $record) {
            // نحصل على اسم السنة من جدول years
            $yearName = Year::find($record->year_id)?->name ?? '-';
    
            // نبحث عن المواد التي قدمها الطالب في هذا العام الدراسي ضمن كل فصل
            $courses = CourseRecord::where('student_id', $studentId)->get();
            
          if(!$courses->isEmpty()){
          
            // جلب العام الأكبر من سجل الطالب
            list($year1, $year2) = explode('-', $record->academic_year);
            $targetYear = (int) max($year1, $year2);

            $hasSemester1 = $courses->contains(function ($course) use ($record, $targetYear) {
                return $course->semester_id == 1 && date('Y', strtotime($course->exam_date)) == $targetYear;
            });

            $hasSemester2 = $courses->contains(function ($course) use ($record, $targetYear) {
                return $course->semester_id == 2 && date('Y', strtotime($course->exam_date)) == $targetYear;
            });

            $hasSemester3 = $courses->contains(function ($course) use ($record, $targetYear) {
                return $course->semester_id == 3 && date('Y', strtotime($course->exam_date)) == $targetYear;
            });

            $notesText = $record->notes->pluck('name')->implode(' - ');
    
            $rows[] = [
                'العام الدراسي' => $record->academic_year,
                'السنة'         => $yearName,
                'النتيجة'       => $record->result,
                'الملاحظات'      => $notesText ?: '-',
                'الدورة الأولى' => $hasSemester1 ? 'نعم' : 'لا',
                'الدورة الثانية' => $hasSemester2 ? 'نعم' : 'لا',
                'الدورة الثالثة' => $hasSemester3 ? 'نعم' : 'لا',
            ];
        }
        else{
            $rows[] = [
                'العام الدراسي' => $record->academic_year,
                'السنة'         => $yearName,
                'النتيجة'       => $record->result,
                'الملاحظات'      => $notesText ?: '-',
                'الدورة الأولى' => 'لا',
                'الدورة الثانية' => 'لا',
                'الدورة الثالثة' => 'لا',
            ];
        }
             $tableHtml = '
                    <style>
                        table.academic-life {
                            border-collapse: collapse;
                            width: 100%;
                            text-align: center;
                            font-family: "Times New Roman", serif;
                            font-size: 14px;
                        }
                        table.academic-life th, table.academic-life td {
                            border: 1px solid black;
                            padding: 6px;
                        }
                        table.academic-life th {
                            background-color: #f2f2f2;
                            font-weight: bold;
                        }
                    </style>

                    <table class="academic-life">
                    <thead>
                    <tr>';
                    

                                            // العناوين
                        foreach (array_keys($rows[0]) as $header) {
                            $tableHtml .= "<th>{$header}</th>";
                        }

                        $tableHtml .= '</tr>
                        </thead>
                        <tbody>';

                        // الصفوف
                        foreach ($rows as $row) {
                            $tableHtml .= '<tr>';
                            foreach ($row as $cell) {
                                $tableHtml .= "<td>{$cell}</td>";
                            }
                            $tableHtml .= '</tr>';
                        }

                        $tableHtml .= '</tbody></table>';
          
           $field2 = Field::where('name', 'academic_life_html')->first();
           FieldValue::Create([
              'request_id' => $request->id,
              'field_id' => $field2->id,
              'value' => $tableHtml,
          ]);
        }
        
        return $rows;
    }


    protected function calculateUsedAndRemainingYears($studentId)
{
    $studentRecords = StudentRecord::with('notes')
        ->where('student_id', $studentId)
        ->get();

    $usedYears = 0;

    foreach ($studentRecords as $record) {
        // نبحث في كل ملاحظة ضمن هذا السجل عن كلمة "إيقاف"
        $hasStopNote = $record->notes->contains(function ($note) {
            return str_contains($note->text, 'إيقاف تسجيل سنوي');
        });

        // إذا لا يحتوي على إيقاف نعده من السنوات المحسوبة
        if ($hasStopNote) {

        }
        else{
            $hasStopNote2 = $record->notes->contains(function ($note) {
                return str_contains($note->text, 'إيقاف تسجيل فصلي');
            });

            if($hasStopNote2){
                $usedYears = $usedYears + 0.5; 
            }
            else{
                $usedYears = $usedYears + 1; 
            }
        }

    
    }

    $remainingYears = max(0, 7 - $usedYears); // لا نسمح بالسالب

    return $remainingYears;
}



}
