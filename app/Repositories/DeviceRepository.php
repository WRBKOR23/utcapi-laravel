<?php

namespace App\Repositories;

use App\Models\Device;

class DeviceRepository implements Contracts\DeviceRepositoryContract
{
    public function upsert ($device)
    {
        Device::updateOrCreate(
            ['device_token' => $device['device_token']],
            ['id_account' => $device['id_account'], 'last_use' => $device['last_use']]
        );
    }
}
