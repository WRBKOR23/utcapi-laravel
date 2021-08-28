<?php

namespace App\Depositories;

use App\Models\GuestInfo;

class GuestInfoDepository implements Contracts\GuestInfoDepositoryContract
{
    private GuestInfo $model;

    /**
     * GuestInfoDepository constructor.
     * @param GuestInfo $model
     */
    public function __construct (GuestInfo $model)
    {
        $this->model = $model;
    }

    public function upsert ($data)
    {
        $this->model->upsert($data);
    }

    public function updatePassword ($id_student, $password)
    {
        $this->model->updatePassword($id_student, $password);
    }

    public function updateDeviceToken ($id_student, $device_token)
    {
        $this->model->updateDeviceToken($id_student, $device_token);
    }

    public function updateDataVersion ($id_student, $type)
    {
        $this->model->updateDataVersion($id_student, $type);
    }

    public function updateDataVersionMultiple ($id_guest_list, $type)
    {
        $this->model->updateDataVersionMultiple($id_guest_list, $type);
    }

    public function get ($id_student)
    {
        return $this->model->get($id_student);
    }

    public function getPassword ($id_student)
    {
        return $this->model->getPassword($id_student);
    }

    public function getDeviceTokens ($id_guest_list): array
    {
        return $this->model->getDeviceTokens($id_guest_list);
    }

    public function getIDGuests ($id_faculty_list, $academic_year_list): array
    {
        return $this->model->getIDGuests($id_faculty_list, $academic_year_list);
    }

    public function getNotificationVersion ($id_student)
    {
        return $this->model->getNotificationVersion($id_student);
    }

    public function getDataVersion ($id_student)
    {
        return $this->model->getDataVersion($id_student);
    }
}
