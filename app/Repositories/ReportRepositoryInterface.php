<?php

namespace App\Repositories;

interface ReportRepositoryInterface
{
    public function topEmployeesByActions();
    public function requestCountPerDocument();
    public function averageProcessingTimePerDocument();
    public function requestCountByStatus();
    
    

}