<?php


namespace App\Services;


use App\Depositories\Contracts\DeviceDepositoryContract;
use App\Services\Contracts\DeviceServiceContract;

class DeviceService implements DeviceServiceContract
{
    private DeviceDepositoryContract $deviceDepository;

    /**
     * DeviceService constructor.
     * @param DeviceDepositoryContract $deviceDepository
     */
    public function __construct (DeviceDepositoryContract $deviceDepository)
    {
        $this->deviceDepository = $deviceDepository;
    }


    public function upsert ($id_student, $device_token)
    {
        $curr_time = $this->_getCurrentTime();
        $this->deviceDepository->upsert($id_student, $device_token, $curr_time);
    }

    private function _getCurrentTime ()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date('Y-m-d H:i:s');
    }
}
