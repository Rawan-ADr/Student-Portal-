<?php
namespace App\Repositories;
use App\Models\RequestLog;
use App\Models\Request;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    public function topEmployeesByActions()
{
    // الاستعلام الأساسي
    $query = RequestLog::select('user_id')
        ->addSelect(DB::raw("
            SUM(CASE WHEN action = 'request_approved' THEN 1 ELSE 0 END) as request_approved,
            SUM(CASE WHEN action = 'request_rejected' THEN 1 ELSE 0 END) as request_rejected,
            SUM(CASE WHEN action = 'request_completed' THEN 1 ELSE 0 END) as request_completed,
            SUM(CASE WHEN action LIKE 'تم تحويل الطلب إلى%' THEN 1 ELSE 0 END) as forwarded_to_next_step,
            COUNT(*) as total_actions
        "))
        ->groupBy('user_id')
        ->with('user:id,name')
        ->orderByDesc('total_actions')
        ->get();

    // تنسيق النتائج
    return $query->map(function ($row) {
        return [
            'user_id' => $row->user_id,
            'user' => [
                'id' => $row->user->id ?? null,
                'name' => $row->user->name ?? 'غير معروف',
            ],
            'total_actions' => (int) $row->total_actions,
            'request_approved' => (int) $row->request_approved,
            'request_rejected' => (int) $row->request_rejected,
            'request_completed' => (int) $row->request_completed,
            'forwarded_to_next_step' => (int) $row->forwarded_to_next_step,
        ];
    });
}

         
    public function requestCountPerDocument() { 
        return Request::select('document_id',
         DB::raw('COUNT(*) as total')) ->groupBy('document_id') 
         ->with('document:id,name') ->get();
         }


     public function averageProcessingTimePerDocument() { 
        $requests = Request::with(['document:id,name', 'logs' => function ($q) {
             $q->orderByDesc('created_at'); }])->get(); 
             $result = [];
              foreach ($requests as $req) { 
                $lastLogTime = optional($req->logs->first())->created_at;
                 if ($lastLogTime) { 
                    $diff = $lastLogTime->diffInMinutes($req->created_at);
                     $docId = $req->document->id;
                      $docName = $req->document->name ?? 'غير معروف';
                       if (!isset($result[$docId])) {
                         $result[$docId] = ['name' => $docName, 'total' => 0, 'count' => 0];
                         } 
                         $result[$docId]['total'] += $diff; $result[$docId]['count']++;
                         } 
                        } 
                        return collect($result)->map(function ($val, $docId) 
                        { 
                            return [ 'document_id' => $docId,
                             'document_name' => $val['name'],
                              'average_processing_time_hours' => round($val['total'] / max($val['count'], 1) / 60, 2) ]; 
                            })->values();
                         }


     public function requestCountByStatus() { 
        return Request::select('status', DB::raw('COUNT(*) as total')) ->groupBy('status') ->get(); 
    } 
    

   
    

}