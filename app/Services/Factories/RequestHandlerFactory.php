<?php

namespace App\Services\Factories;

use App\Models\Document;
use App\Services\RequestHandlers\RequestHandlerInterface;
use App\Services\RequestHandlers\TranscriptRequestHandler;
use App\Services\RequestHandlers\SubmittedRequestHandler;

class RequestHandlerFactory
{
    public static function make(Document $document): RequestHandlerInterface
    {
        switch ($document->name) {
            case 'كشف علامات':
                return new TranscriptRequestHandler();

            case 'وثيقة ترفع':
                return new SubmittedRequestHandler();

            default:
                throw new \Exception("لا يوجد معالج لهذا النوع من الوثائق");
        }
    }
}
