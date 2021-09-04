<?php


    namespace App\Services\Contracts;


    interface NotifyServiceContract
    {
        public function sendNotification ($noti, $id_account_list);

    }
