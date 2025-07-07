<?php

namespace App\Services\RequestHandlers;

use App\Models\Request;

class TranscriptRequestHandler implements RequestHandlerInterface
{
    public function handle($request)
    {
        // منطق المعالجة لكشف العلامات
        // مثلاً جلب العلامات من جدول marks وعرضها أو توليد PDF إلخ.

        $student = $request->student;
        $transcript = $student->marks()->with('course')->get();

        return $transcript;
    }
}
