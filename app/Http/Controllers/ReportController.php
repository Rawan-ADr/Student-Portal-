<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportController extends Controller
{
    private ReportService $reportService;

    public function __construct(ReportService $reportService){
       $this->reportService = $reportService;
    }

      public function topEmployeesByActions()
    {
        return response()->json($this->reportService->topEmployeesByActions());
    }

    public function requestCountPerDocument()
    {
        return response()->json($this->reportService->requestCountPerDocument());
    }

    public function averageProcessingTimePerDocument()
    {
        return response()->json($this->reportService->averageProcessingTimePerDocument());
    }

    public function requestCountByStatus()
    {
        return response()->json($this->reportService->requestCountByStatus());
    }
}
