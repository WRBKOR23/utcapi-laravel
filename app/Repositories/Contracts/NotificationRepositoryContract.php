<?php

namespace App\Repositories\Contracts;

interface NotificationRepositoryContract
{
    public function insertGetID ($data);

    public function setDelete ($id_notification_list);

    public function getNotifications ($id_sender, $num);

    public function getDeletedNotifications ();
}
