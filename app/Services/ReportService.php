<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Repositories\ReportRepositoryInterface;



class ReportService
{
    private   $reportRepository;
    

     public function __construct(ReportRepositoryInterface $reportRepository){
        $this->reportRepository = $reportRepository;
     }


       public function topEmployeesByActions()
    {
        if ( Auth::user()->hasRole('admin')) {
        return $this->reportRepository->topEmployeesByActions();
        }
        else{
            return"you can not see reports";
        }
    }

    public function requestCountPerDocument()
    {
         if ( Auth::user()->hasRole('admin')) {
        return $this->reportRepository->requestCountPerDocument();
         }
        else{
            return"you can not see reports";
        }
    }

    public function averageProcessingTimePerDocument()
    {
         if ( Auth::user()->hasRole('admin')) {
        return $this->reportRepository->averageProcessingTimePerDocument();
         }
        else{
            return"you can not see reports";
        }
    }

    public function requestCountByStatus()
    {
        if ( Auth::user()->hasRole('admin')) {
        return $this->reportRepository->requestCountByStatus();
        }
        else{
            return"you can not see reports";
        }
    }


   
    }

