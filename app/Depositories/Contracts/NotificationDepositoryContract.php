<?php

    namespace App\Depositories\Contracts;

    interface NotificationDepositoryContract
    {
        public function insertGetID($data);

        public function setDelete($id_notification_list);

        public function getNotifications ($id_sender, $num);

    }
