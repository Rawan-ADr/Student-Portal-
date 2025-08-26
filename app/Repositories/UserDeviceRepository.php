<?php
namespace App\Repositories;
use App\Models\UserDevice;

class UserDeviceRepository implements UserDeviceRepositoryInterface
{
     public function updateOrCreate($deviceableId, $deviceableType, $deviceToken, $deviceType = null)
    {
        return UserDevice::updateOrCreate(
            [
                'deviceable_id'   => $deviceableId,
                'deviceable_type' => $deviceableType,
            ],
            [
                'device_token' => $deviceToken,
                'device_type'  => $deviceType,
            ]
        );
    }


   
    

}