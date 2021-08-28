<?php


    namespace App\Services\Contracts;


    interface NotifyServiceContract
    {
        public function sendNotification ($noti, $id_student_list);

    }
