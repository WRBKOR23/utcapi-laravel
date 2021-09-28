<?php

    namespace App\Depositories\Contracts;

    interface NotificationAccountDepositoryContract
    {
        public function insertMultiple($data);

        public function getNotifications ($id_account, $id_notification = '0');

    }
