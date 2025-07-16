<?php

namespace App\Services\Factories;

use App\Models\Document;
use App\Services\RequestHandlers\RequestHandlerInterface;
use App\Services\RequestHandlers\TranscriptRequestHandler;
use App\Services\RequestHandlers\SubmittedRequestHandler;
use App\Services\RequestHandlers\SpecialRequestHandler;

class RequestHandlerFactory
{
    public static function make(Document $document): RequestHandlerInterface
    {
        switch ($document->name) {
            case 'كشف علامات':
                return new TranscriptRequestHandler();

            case 'وثيقة ترفع':
                return new SubmittedRequestHandler();
            case 'طلب خاص':
                return new SpecialRequestHandler();

            default:
                throw new \Exception("لا يوجد معالج لهذا النوع من الوثائق");
        }
    }
}
