<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\UserDeviceRepositoryInterface;


class DeviceUserService
{
    
    private  $repository;
    

     public function __construct(UserDeviceRepositoryInterface $repository ){
        $this->repository = $repository;

     }
     


    public function saveToken($user, $deviceToken, $deviceType = null)
    {
        return $this->repository->updateOrCreate(
            $user->id,
            get_class($user),
            $deviceToken,
            $deviceType
        );
    }

}