<?php

namespace App\Services\Notifications;

use App\Models\Faq;
use App\Models\Notifications as ModelsNotifications;
use App\Models\Services;


class Notifications
{

    public static function  sendNotification(array $data)
    {
        $prepare = collect($data);

        ModelsNotifications::create($prepare->toArray());
    }
 
}
