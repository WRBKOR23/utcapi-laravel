<?php

namespace App\Repositories\Contracts;

interface DeviceRepositoryContract
{
    public function upsert ($device);
}
