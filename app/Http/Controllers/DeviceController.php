<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeviceUserService;

class DeviceController extends Controller
{
    private DeviceUserService $service;

    public function __construct(DeviceUserService $service){
        $this->service = $service;
    }

      public function saveToken(Request $request)
    {
        $request->validate([
            "device_token" => "required|string",
            "device_type"  => "nullable|string"
        ]);

        $user = auth()->user();

        $this->service->saveToken($user, $request->device_token, $request->device_type);

        return response()->json(["message" => "Device token saved successfully"]);
    }
}