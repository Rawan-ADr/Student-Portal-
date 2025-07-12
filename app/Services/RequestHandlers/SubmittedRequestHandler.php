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

class SubmittedRequestHandler implements RequestHandlerInterface
{
    public function handle($request)
    {
        $studentId = $request->student_id;

        $student = Student::find($studentId);
        $studentFile = StudentFile::where('student_id', $studentId)->first();
        $semester_cycle=Semester::find( $studentFile->semester_id);
        

        $fieldData = [
            'الاختصاص' => $student->department,
            'الرقم الجامعي' => $student->university_number,
            'من السنة' => $this->getYearNameById($studentFile->year_id - 1),
            'الى السنة' => $this->getYearNameById($studentFile->year_id),
            'الدورة الفصلية' =>$semester_cycle->name,
            'العام الدراسي' => $studentFile->academic_year,
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
        $replacements = [];
        $contentTemplate = $document->content;

        foreach ($fieldValues as $fieldValue) {
            $replacements['{{' . $fieldValue->field->name . '}}'] = $fieldValue->value;
        }
    
        // استبدال المتغيرات بالمحتوى
        $finalContent = strtr($contentTemplate, $replacements);
    
       //////
        $document->content = $finalContent;
        $document->save();

        dd($finalContent);

        // // عملية الاستبدال (كما شرحت سابقًا)
        // foreach ($fieldValues as $key => $value) {
        //     $contentTemplate = str_replace('{{' . $key . '}}', $value, $contentTemplate);
        // }

        // // حفظ المحتوى الجديد داخل نفس الوثيقة
        // $document->content = $contentTemplate;
        // $document->save();
        // dd($contentTemplate);
        return $request;
    }

    private function getYearNameById($id)
    {
        $year = Year::find($id);
        return $year ? $year->name : null;
    }
}
