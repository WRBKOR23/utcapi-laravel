<?php


namespace App\Services;


use App\Repositories\Contracts\DeviceRepositoryContract;
use App\Services\Contracts\DeviceServiceContract;

class DeviceService implements DeviceServiceContract
{
    private DeviceRepositoryContract $deviceRepository;

    /**
     * DeviceService constructor.
     * @param DeviceRepositoryContract $deviceRepository
     */
    public function __construct (DeviceRepositoryContract $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }


    public function upsert ($id_account, $device_token)
    {
        $curr_time = $this->_getCurrentTime();
        $this->deviceRepository->upsert($id_account, $device_token, $curr_time);
    }

    private function _getCurrentTime ()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date('Y-m-d H:i:s');
    }
}
