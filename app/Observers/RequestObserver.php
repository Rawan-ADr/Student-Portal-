<?php

namespace App\Observers;

use App\Models\RequestLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Request;
use App\Models\FlowStep;

class RequestObserver
{
    /**
     * Handle the Request "created" event.
     */
    public function created(Request $request): void
    {
        //
    }

    /**
     * Handle the Request "updated" event.
     */
    public function updated(Request $request): void
    {
           $originalStatus = $request->getOriginal('status');
           $newStatus = $request->status;

         $originalPoint = $request->getOriginal('point');
         $newPoint = $request->point;

        $hasStatusChanged = $request->isDirty('status') && $originalStatus !== $newStatus;
        $hasPointChanged = $request->isDirty('point') && $originalPoint !== $newPoint;

       if ($originalStatus === null && $newStatus === 'under review') {
            return;
        }

        if (!$hasStatusChanged && !$hasPointChanged) {
            return;
        }

         $action = null;

        if ($hasStatusChanged) {
           $statusMap = [
            'in process' => 'request_approved',
            'rejected' => 'request_rejected',
            'required modification' => 'modification_requested',
            'done' => 'request_completed',
           ];
          $action = $statusMap[$newStatus] ?? 'status_changed_to_' . $newStatus;
      } elseif ($hasPointChanged) {
        //  استخراج اسم الخطوة (step_name) من جدول flow_steps
          $step = FlowStep::find($newPoint);
          $stepName = $step ? $step->step_name : 'خطوة غير معروفة';
          $action = 'تم تحويل الطلب إلى ' . $stepName;
     }

       if ($action) {
           RequestLog::create([
            'request_id' => $request->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'note' => null,
        ]);
    }
    
    }

    /**
     * Handle the Request "deleted" event.
     */
    public function deleted(Request $request): void
    {
        //
    }

    /**
     * Handle the Request "restored" event.
     */
    public function restored(Request $request): void
    {
        //
    }

    /**
     * Handle the Request "force deleted" event.
     */
    public function forceDeleted(Request $request): void
    {
        //
    }
}
