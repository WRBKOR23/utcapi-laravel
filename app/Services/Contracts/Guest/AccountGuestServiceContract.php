<?php


namespace App\Services\Contracts\Guest;


interface AccountGuestServiceContract
{
    public function updatePassword($id_student, $password);

    public function updateDeviceToken($id_student, $device_token);

    public function getPassword ($id_student);

    public function getDeviceTokens ($id_faculty_list, $academic_year_list);
}
