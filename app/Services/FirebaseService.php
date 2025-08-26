<?php


namespace App\Services;


use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\UserDevice;


class FirebaseService
{
    
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        $this->messaging = $factory->createMessaging();
    }

    // إرسال إشعار لجهاز واحد
    public function sendToDevice($deviceToken, $title, $body)
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification);

        return $this->messaging->send($message);
    }

    // إرسال إشعار لمستخدم واحد
    public function sendToUser($user, $title, $body)
    {
        $devices = UserDevice::where('deviceable_id', $user->id)
            ->where('deviceable_type', get_class($user))
            ->get();

        foreach ($devices as $device) {
            $this->sendToDevice($device->device_token, $title, $body);
        }
    }

    // إرسال إشعار لمجموعة من المستخدمين (Users أو Students)
    public function sendToUsers(array $users, $title, $body)
    {
        foreach ($users as $user) {
            $this->sendToUser($user, $title, $body);
        }
    }
     


    


}