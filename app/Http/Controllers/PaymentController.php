<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Models\Request as RequestModel;
use App\Http\Requests\ConfirmPaymentRequest;

class PaymentController extends Controller
{
    public function confirm(HttpRequest $request)
    {
        $requestId = $request->input('request_id');
        $studentId = $request->input('student_id');

        $docRequest = RequestModel::find($requestId);

        if (!$docRequest || $docRequest->student_id != $studentId) {
            return response()->json([
                'message' => 'Request not found or invalid student.'
            ], 404);
        }

        if ($docRequest->payment_status !== 'paid') {
            $docRequest->payment_status = 'paid';
            $docRequest->save();
        }

        return response()->json([
            'message' => 'Payment confirmed successfully.',
            'request_id' => $requestId
        ]);
    }
}