<?php

namespace App\Repositories;

interface UserDeviceRepositoryInterface
{
    public function updateOrCreate($deviceableId, $deviceableType, $deviceToken, $deviceType = null);
    
    

}