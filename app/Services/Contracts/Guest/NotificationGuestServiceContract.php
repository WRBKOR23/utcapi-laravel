<?php


namespace App\Services\Contracts\Guest;


interface NotificationGuestServiceContract
{
    public function pushNotificationGuestBFC ($id_notification, $id_faculty_list, $academic_year_list);

    public function getNotifications($id_guest, $id_notification);
}
