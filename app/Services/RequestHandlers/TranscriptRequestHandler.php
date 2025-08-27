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
use App\Models\Mark;
use App\Models\Attachment;
use App\Models\AttchmentValue;
use App\Models\Document_Attachment;
use PDF;
use Mpdf\Mpdf;

class TranscriptRequestHandler implements RequestHandlerInterface
{
     public function handle($request)
    {
        $studentId = $request->student_id;

        $student = Student::find($studentId);
        $studentFile = StudentFile::where('student_id', $studentId)->first();
        $semester_cycle=Semester::find( $studentFile->semester_id);
      

        $fieldValues = FieldValue::where('request_id', $request->id)->with('field')->get();
        $document=Document::find(  $request->document_id);;

       $pp=$this->generateTranscriptPdf($request);
        // تجهيز مصفوفة القيم للاستبدال
        $replacements = [];
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

    protected function generateTranscriptPdf($request)
{
    $studentId = $request->student_id;

    $records = CourseRecord::with(['course.year', 'mark'])
    ->where('student_id', $studentId)
    ->whereIn('id', function ($q) use ($studentId) {
        $q->selectRaw('MAX(id)')
          ->from('course_records')
          ->where('student_id', $studentId)
          ->groupBy('course_id');
    })
    ->get();

    // 2. تجهيز بيانات الجدول
    $rows = [];
    foreach ($records as $record) {
       
            $rows[] = [
                'year'       => $record->course->year->name ?? '-',
                'course'       => $record->course->name ?? '-',
                'semester'     => $record->semester_id,
                'total_mark'   => $record->mark->total_mark ?? '-',
                'practical_mark'    => $record->mark->practical_mark ?? '-',
                'theoretical_mark'  => $record->mark->theoretical_mark ?? '-',
                'result'       => $record->mark->status ?? '-',
            ];
        
    }

    // 3. إنشاء الـ PDF من View
    // $pdf = PDF::loadView('pdf.transcript', ['rows' => $rows, 'student' => $request->student]);
    // $pdf = \PDF::loadView('pdf.transcript',  ['rows' => $rows, 'student' => $request->student])
    // ->setOptions([
    //     'isHtml5ParserEnabled' => true,
    //     'isRemoteEnabled' => true,
    // ]);
    
        $html = view('pdf.transcript',  ['rows' => $rows, 'student' => $request->student])->render();

        // إنشاء ملف PDF باستخدام mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'amiri', // خط عربي
        ]);

        $mpdf->WriteHTML($html);

        // مسار حفظ الملف
        $pdfPath = storage_path("app/public/transcript_{$request->id}.pdf");
        $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

    // // 4. حفظه في مجلد مؤقت
    // $fileName = 'transcript_' . $studentId . '.pdf';
    // $filePath = storage_path('app/public/' . $fileName);
    // $pdf->save($filePath);

   
    // 5. تخزينه كمرفق للطلب
    $Attachment=Attachment::create([
        'name'=> 'مرفق كشف علامات',
        'description'=>'كشف علامات للطالب',
        'type'=>'pdf',
    ]);

    $Attachment->save();

            AttchmentValue::create([
                                'request_id' => $request->id,
                                'attachment_id' => $Attachment->id,
                                'value' => $pdfPath,
                            ]);

                            
            // Document_Attachment::create([
            //                         'document_id'=> $request->document->id,
            //                         'attachment_id'=>$Attachment->id,
            //                         'is_required'=>0
            //                 ]);

    return $pdfPath;
}
}
