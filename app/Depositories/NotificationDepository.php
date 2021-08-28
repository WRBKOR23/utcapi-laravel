<?php

namespace App\Depositories;

use App\Depositories\Contracts\NotificationDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Models\Notification;
use Illuminate\Support\Collection;

class NotificationDepository implements NotificationDepositoryContract
{
    // Notification Model
    private Notification $model;

    public function __construct (Notification $model)
    {
        $this->model = $model;
    }

    public function insertGetID ($data): int
    {
        return $this->model->insertGetID(SharedFunctions::setUpNotificationData($data));
    }

    public function setDelete ($id_notification_list)
    {
        $this->model->setDelete($id_notification_list);
    }

    public function getNotifications ($id_sender, $num): Collection
    {
        return $this->model->getNotifications($id_sender, $num);
    }
}
