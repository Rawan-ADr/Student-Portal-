<?php
namespace App\Services\RequestHandlers;

use App\Models\Request;
use App\Models\Field;
use App\Models\FieldValue;
use App\Models\Document;

class SpecialRequestHandler implements RequestHandlerInterface
{
    public function handle($request)
    {

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
    

        // حفظ النتيجة في الطلب (يفضل إضافة عمود جديد مثل filled_content)
        $request->content_value = $finalContent;
        $request->save();


        dd($finalContent);

        return $request;
    }
}
