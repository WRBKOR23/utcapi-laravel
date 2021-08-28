<?php


namespace App\Services\Contracts\Guest;


interface NotifyGuestServiceContract
{
    public function sendNotification ($noti, $id_guest_list);

}
