<?php

namespace App\Repositories\Contracts;

interface GuestInfoDepositoryContract
{
    public function upsert ($data);

    public function updatePassword ($id_student, $password);

    public function updateDeviceToken ($id_student, $device_token);

    public function updateDataVersion ($id_student, $type);

    public function updateDataVersionMultiple ($id_guest_list, $type);

    public function get ($id_student);

    public function getPassword ($id_student);

    public function getDeviceTokens ($id_guest_list);

    public function getIDGuests ($id_faculty_list, $academic_year_list);

    public function getNotificationVersion ($id_student);

    public function getDataVersion ($id_student);

}
