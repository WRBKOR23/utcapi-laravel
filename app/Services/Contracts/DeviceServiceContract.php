<?php

    namespace App\Services\Contracts;

    interface DeviceServiceContract
    {
        public function upsert ($id_student, $device_token);
    }
