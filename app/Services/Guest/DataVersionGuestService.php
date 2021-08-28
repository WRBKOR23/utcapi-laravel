<?php


namespace App\Services\Guest;


use App\Depositories\Contracts\GuestInfoDepositoryContract;
use App\Services\Contracts\Guest\DataVersionGuestServiceContract;

class DataVersionGuestService implements DataVersionGuestServiceContract
{
    private GuestInfoDepositoryContract $model;

    /**
     * DataVersionGuestService constructor.
     * @param GuestInfoDepositoryContract $guestInfoDepository
     */
    public function __construct (GuestInfoDepositoryContract $guestInfoDepository)
    {
        $this->model = $guestInfoDepository;
    }

    public function getDataVersion ($id_student)
    {
        return $this->model->getDataVersion($id_student);
    }

    public function getNotificationVersion ($id_student)
    {
        return $this->model->getNotificationVersion($id_student);
    }
}
