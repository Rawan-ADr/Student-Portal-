<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Validation;

class ValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $validations = [
            ['validation_rule' => 'required',        'error_message' => 'هذا الحقل مطلوب'],
            ['validation_rule' => 'nullable',        'error_message' => 'هذا الحقل يمكن أن يكون فارغًا'],
            ['validation_rule' => 'string',          'error_message' => 'يجب أن يكون نصًا'],
            ['validation_rule' => 'max:255',         'error_message' => 'الحد الأقصى لعدد الأحرف هو 255'],
            ['validation_rule' => 'min:3',           'error_message' => 'الحد الأدنى لعدد الأحرف هو 3'],
            ['validation_rule' => 'between:3,10',    'error_message' => 'القيمة يجب أن تكون بين 3 و 10'],
            ['validation_rule' => 'email',           'error_message' => 'يرجى إدخال بريد إلكتروني صحيح'],
            ['validation_rule' => 'numeric',         'error_message' => 'يجب أن يكون الحقل رقمًا'],
            ['validation_rule' => 'integer',         'error_message' => 'يجب أن يكون عددًا صحيحًا'],
            ['validation_rule' => 'boolean',         'error_message' => 'يجب أن تكون القيمة صح أو خطأ'],
            ['validation_rule' => 'date',            'error_message' => 'يرجى إدخال تاريخ صحيح'],
            ['validation_rule' => 'url',             'error_message' => 'الرابط غير صالح'],
            ['validation_rule' => 'confirmed',       'error_message' => 'تأكيد القيمة غير مطابق'],
            ['validation_rule' => 'unique:users,email', 'error_message' => 'البريد الإلكتروني مستخدم بالفعل'],
            ['validation_rule' => 'exists:users,id', 'error_message' => 'المُعرّف غير موجود في قاعدة البيانات'],
            ['validation_rule' => 'regex:/^[a-zA-Z0-9_]+$/', 'error_message' => 'يُسمح فقط بالحروف والأرقام والشرطات السفلية'],
            ['validation_rule' => 'in:small,medium,large', 'error_message' => 'القيمة يجب أن تكون small أو medium أو large'],
            ['validation_rule' => 'after:today',     'error_message' => 'يجب أن يكون التاريخ بعد اليوم'],
            ['validation_rule' => 'before:today',    'error_message' => 'يجب أن يكون التاريخ قبل اليوم'],
            ['validation_rule' => 'same:password',   'error_message' => 'القيمة يجب أن تطابق كلمة المرور'],
            ['validation_rule' => 'different:username', 'error_message' => 'القيمة يجب أن تكون مختلفة عن اسم المستخدم'],
        ];

        foreach ($validations as $validation) {
            Validation::updateOrInsert(
                ['validation_rule' => $validation['validation_rule']],
                ['error_message' => $validation['error_message']]
            );
        }
    }
}
