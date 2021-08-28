<?php

    namespace App\Depositories\Contracts;

    interface NotificationAccountDepositoryContract
    {
        public function insertMultiple($id_account_list, $id_notification);

        public function getIDAccounts ($id_notification_list);

        public function getNotifications ($id_account, $id_notification = '0');

    }
