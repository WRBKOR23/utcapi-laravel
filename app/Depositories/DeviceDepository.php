<?php

    namespace App\Depositories;

    use App\Depositories\Contracts\DeviceDepositoryContract;
    use App\Models\Device;

    class DeviceDepository implements DeviceDepositoryContract
    {
        // Device Model
        private Device $model;

        public function __construct (Device $model)
        {
            $this->model = $model;
        }

        public function getTokens ($id_account_list) : array
        {
            if (empty($id_account_list)) {
                return [];
            }

            return $this->model->getDeviceTokens($id_account_list);
        }

        public function deleteMultiple ($device_token_list)
        {
            if (empty($device_token_list)) {
                return;
            }

            $this->model->deleteMultiple($device_token_list);
        }

        public function upsert ($id_student, $device_token, $curr_time)
        {
            $this->model->upsert($id_student, $device_token, $curr_time);
        }

    }
