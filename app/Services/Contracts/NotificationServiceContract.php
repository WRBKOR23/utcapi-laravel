<?php


    namespace App\Services\Contracts;


    interface NotificationServiceContract
    {
        public function pushNotificationBFC($notification, $class_list);

        public function pushNotificationBMC($notification, $class_list);

        public function getNotificationByReceiver($id_account, $is_student, $id_notification = '0');

        public function getNotificationBySender ($id_sender, $num);

        public function setDelete($id_notification_list);
    }
