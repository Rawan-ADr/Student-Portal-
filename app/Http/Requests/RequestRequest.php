<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Field;
use App\Models\Attachment;

class RequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    

public function rules()
{
    $rules = [
       // 'document_id' => ['required', 'exists:documents,id'],
        'fields' => ['required', 'array'],
    ];

    // إذا تم إرسال document_id
    // if ($this->document_id) {
    //     // جيب الحقول المرتبطة بالوثيقة من قاعدة البيانات
    //    // $fields = Field::where('document_id', $this->document_id)->get()->with('fieldType')->get();
    //    $fields=Field::all();
    //     foreach ($fields as $field) {
    //         $rule = ['required'];

    //         switch ($field->fieldType->type) {
    //             case 'text':
    //                 $rule[] = 'string';
    //                 $rule[] = 'max:255';
    //                 break;

    //             case 'number':
    //                 $rule[] = 'numeric';
    //                 break;

    //             case 'date':
    //                 $rule[] = 'date';
    //                 break;

    //             case 'email':
    //                 $rule[] = 'email';
    //                 break;

    //             // أضف أنواع إضافية حسب مشروعك

    //             default:
    //                 $rule[] = 'string';
    //         }

    //         // أضف القاعدة إلى array التحقق
    //         $rules["fields.{$field->id}"] = $rule;
    //     }

      
    //         // $attachments = Attachment::where('document_id', $this->document_id)->get();
    
    //         $attachments=Attachment::all();

    //         foreach ($attachments as $attachment) {
    //             $rule = ['required', 'file']; // كل المرفقات ملفات بشكل عام
    
    //             switch ($attachment->type) {
    //                 case 'image':
    //                     $rule[] = 'mimes:jpeg,png,jpg';
    //                     break;
    //                 case 'pdf':
    //                     $rule[] = 'mimes:pdf';
    //                     break;
    //                 case 'doc':
    //                     $rule[] = 'mimes:doc,docx';
    //                     break;
    //                 case 'zip':
    //                     $rule[] = 'mimes:zip,rar';
    //                     break;
    //                 // أضف أنواع حسب الحاجة
    //                 default:
    //                     $rule[] = 'mimes:pdf,jpg,png';
    //             }
    
    //             $rules["attachments.{$attachment->id}"] = $rule;
    //         }


    //     }
    
    
    

     return $rules;
}

}
