<?php

    namespace App\Depositories\Contracts;

    interface DeviceDepositoryContract
    {
        public function getTokens($id_student_list);

        public function deleteMultiple ($device_token_list);

        public function upsert ($id_student, $device_token, $curr_time);

    }