<?php

namespace App\Repositories;

use App\Repositories\Contracts\DeviceRepositoryContract;
use App\Models\Device;

class DeviceRepository implements DeviceRepositoryContract
{
    public function upsert ($id_account, $device_token, $curr_time)
    {
        Device::updateOrCreate(
            ['device_token' => $device_token],
            ['id_account' => $id_account, 'last_use' => $curr_time]
        );
    }
}
