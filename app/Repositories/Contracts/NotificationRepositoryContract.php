<?php

namespace App\Repositories\Contracts;

interface NotificationRepositoryContract
{
    public function getIDNotifications ($id_account, $id_notification_offset);

    public function getNotifications ($id_notifications);

    public function getDeletedNotifications ();
}
