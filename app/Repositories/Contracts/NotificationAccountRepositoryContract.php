<?php

namespace App\Repositories\Contracts;

interface NotificationAccountRepositoryContract
{
    public function insertMultiple ($data);

    public function getIDAccounts ($id_notification_list);

    public function getNotifications ($id_account, $id_notification = '0');
}
