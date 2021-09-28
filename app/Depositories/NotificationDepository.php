<?php

namespace App\Depositories;

use App\Depositories\Contracts\NotificationDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Models\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NotificationDepository implements NotificationDepositoryContract
{
    // Notification Model
    private Notification $model;

    public function __construct (Notification $model)
    {
        $this->model = $model;
    }

    public function insertGetID ($data) : int
    {
        return Notification::create($data)->id_notification;
    }

    public function setDelete ($id_notification_list)
    {
        Notification::whereIn('id_notification', $id_notification_list)
                    ->update(['is_delete' => 1]);
    }

    public function getNotifications ($id_sender, $num) : Collection
    {
        return Notification::where('id_sender', '=', $id_sender)
                           ->where('is_delete', '=', 0)
                           ->orderBy('id_notification', 'desc')
                           ->offset($num)
                           ->limit(15)
                           ->select('id_notification', 'title', 'content',
                                    'time_create', 'time_start', 'time_end')
                           ->get();
    }
}
