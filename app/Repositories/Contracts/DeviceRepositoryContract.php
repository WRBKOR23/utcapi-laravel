<?php

namespace App\Repositories\Contracts;

interface DeviceRepositoryContract
{
    public function upsert ($id_account, $device_token, $curr_time);
}
