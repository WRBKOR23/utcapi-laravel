<?php

namespace App\Depositories;

use App\Depositories\Contracts\DeviceDepositoryContract;
use App\Models\Device;
use Illuminate\Support\Facades\DB;

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
        $this->_createTemporaryTable($id_account_list);

        return DB::table(Device::table_as)
                 ->join('temp2', 'd.id_account', '=', 'temp2.id_account')
                 ->pluck('device_token')
                 ->toArray();
    }

    public function deleteMultiple ($device_token_list)
    {
        Device::whereIn('device_token', $device_token_list)->delete();
    }

    public function upsert ($id_account, $device_token, $curr_time)
    {
        Device::updateOrCreate(
            ['device_token' => $device_token],
            ['id_account' => $id_account, 'last_use' => $curr_time]
        );
    }

    private function _createTemporaryTable ($id_account_list)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp2 (
                  id_account mediumint unsigned NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        DB::unprepared($sql_query);
        DB::table('temp2')->insert($id_account_list);
    }

}
