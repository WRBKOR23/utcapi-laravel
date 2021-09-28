<?php


    namespace App\Services\Contracts;


    interface NotificationServiceContract
    {
        public function pushNotificationBFC($notification, $class_list);

        public function pushNotificationBMC($notification, $class_list);

        public function getNotificationsApp($id_account, $id_notification = '0');

        public function getNotificationsWeb ($id_sender, $num);

        public function setDelete($id_notification_list);
    }
