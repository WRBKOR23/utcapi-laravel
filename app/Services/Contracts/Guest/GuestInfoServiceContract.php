<?php


namespace App\Services\Contracts\Guest;


interface GuestInfoServiceContract
{
    public function updateDeviceToken($id_student, $device_token);
}
