<?php

namespace App\Http\Controllers;

use App\Http\Service\NotificationService;
use App\Models\Notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function getNotifications(){
        $data = NotificationService::getAll();
        return response()->json($data,200);
    }

    public function readNotifications(Request $request){
        $data = NotificationService::readNotifications($request);
        return response()->json($data,200);
    }
}
