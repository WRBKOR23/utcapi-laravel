<?php

namespace App\Depositories;

use App\Models\NotificationGuest;

class NotificationGuestDepository implements Contracts\NotificationGuestDepositoryContract
{
    private NotificationGuest $model;

    /**
     * NotificationGuestDepository constructor.
     * @param NotificationGuest $model
     */
    public function __construct (NotificationGuest $model)
    {
        $this->model = $model;
    }

    public function getIDNotifications ($id_guest, $id_notification): array
    {
        return $this->model->getIDNotifications($id_guest, $id_notification);
    }

    public function getNotifications ($id_notification_list): array
    {
        return $this->model->getNotifications($id_notification_list);
    }

    public function insertMultiple ($data)
    {
        $this->model->insertMultiple($data);
    }
}
