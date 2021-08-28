<?php

namespace App\Depositories\Contracts;

interface NotificationGuestDepositoryContract
{
    public function insertMultiple($data);

    public function getIDNotifications($id_guest, $id_notification);

    public function getNotifications ($id_notification_list);

}
