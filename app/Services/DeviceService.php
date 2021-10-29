<?php

namespace App\Services;

use App\Repositories\Contracts\DeviceRepositoryContract;

class DeviceService implements Contracts\DeviceServiceContract
{
    private DeviceRepositoryContract $deviceRepository;

    /**
     * @param DeviceRepositoryContract $deviceRepository
     */
    public function __construct (DeviceRepositoryContract $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }


    public function upsert ($id_account, $device_token)
    {
        $device = [
            'device_token' => $device_token,
            'id_account'   => $id_account,
            'last_use'     => $this->_getCurrentTime(),
        ];
        $this->deviceRepository->upsert($device);
    }

    private function _getCurrentTime ()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date('Y-m-d H:i:s');
    }
}
