<?php

namespace App\Factories;

use App\Models\Document;
use App\Services\RequestHandlers\RequestHandlerInterface;
use App\Services\RequestHandlers\TranscriptRequestHandler;

class RequestHandlerFactory
{
    public static function make(Document $document): RequestHandlerInterface
    {
        switch ($document->name) {
            case 'كشف علامات':
                return new TranscriptRequestHandler();

            // case 'إيقاف تسجيل':
            //     return new StopEnrollmentHandler();

            default:
                throw new \Exception("لا يوجد معالج لهذا النوع من الوثائق");
        }
    }
}
