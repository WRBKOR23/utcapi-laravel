<?php


namespace App\Services\Contracts\Guest;


interface DataVersionGuestServiceContract
{
    public function getDataVersion($id_student);

    public function getNotificationVersion($id_student);
}
