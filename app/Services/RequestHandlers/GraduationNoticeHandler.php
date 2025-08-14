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
use Illuminate\Support\Facades\DB;

class GraduationNoticeHandler implements RequestHandlerInterface
{
    public function handle($request)
    {
        $studentId = $request->student_id;

        $student = Student::find($studentId);
        $studentFile = StudentFile::where('student_id', $studentId)->first();
        $semester_cycle=Semester::find( $studentFile->semester_id);
        if($studentFile->status!=='متخرج'){
            $request-> status='rejected';
            $request->save();
            return $request;
        }

        $average = DB::table('course_records')
                        ->join('marks', 'marks.course_record_id', '=', 'course_records.id')
                        ->where('course_records.student_id', $studentId)
                        ->where('marks.status','pass')
                        ->avg('marks.total_mark');


        $e = $average >= 85;
        $v = $average >=70 && $average <=85;
        if($e){
            $g='ممتاز';
        }
        if($v){
            $g='جيد جدا';
        }
        else{
            $g='جيد';
        }
        $fieldData = [
            'الاختصاص' => $student->department,
            'كلية' => 'الهندسة المعلوماتية',
            'التقدير' =>  $g,
            'المعدل' => $average,
            'الدورة الفصلية' =>$semester_cycle->name,
            'عام التخرج' => $studentFile->academic_year,
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

        // تجهيز مصفوفة القيم للاستبدال
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
}
