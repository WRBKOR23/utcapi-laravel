<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Device extends Model
    {
        use HasFactory;

        public const table = 'device';
        public const table_as = 'device as d';

        public function getDeviceTokens ($id_account_list) : array
        {
            $this->_createTemporaryTable($id_account_list);

            return DB::table(self::table_as)
                ->join('temp2', 'd.id_account', '=', 'temp2.id_account')
                ->pluck('device_token')
                ->toArray();
        }

        public function deleteMultiple ($device_token_list)
        {
            DB::table(self::table)
                ->whereIn('device_token', $device_token_list)
                ->delete();
        }

        public function upsert ($id_student, $device_token, $curr_time)
        {
            DB::table(self::table)
                ->updateOrInsert([
                    'device_token' => $device_token,
                ], [
                    'id_student' => $id_student,
                    'last_use' => $curr_time
                ]);
        }

        private function _createTemporaryTable ($id_account_list)
        {
            $sql_query_1 =
                'CREATE TEMPORARY TABLE temp2 (
                  id_account mediumint unsigned NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

            $sql_of_list =
                implode(',', array_fill(0, count($id_account_list), '(?)'));

            $sql_query_2 =
                'INSERT INTO temp2
                    (id_account)
                VALUES
                    ' . $sql_of_list;

            DB::unprepared($sql_query_1);

            DB::statement($sql_query_2, $id_account_list);
        }
    }
