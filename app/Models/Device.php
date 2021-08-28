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

        public function getDeviceTokens ($id_student_list) : array
        {
            $this->_createTemporaryTable($id_student_list);

            return DB::table(self::table_as)
                ->join('temp2', 'd.ID_Student', '=', 'temp2.ID_Student')
                ->pluck('Device_Token')
                ->toArray();
        }

        public function deleteMultiple ($device_token_list)
        {
            DB::table(self::table)
                ->whereIn('Device_Token', $device_token_list)
                ->delete();
        }

        public function upsert ($id_student, $device_token, $curr_time)
        {
            DB::table(self::table)
                ->updateOrInsert([
                    'Device_Token' => $device_token,
                    'ID_Student' => $id_student,
                    'Last_Use' => $curr_time
                ], [
                    'ID_Student' => $id_student,
                    'Last_Use' => $curr_time
                ]);
        }

        private function _createTemporaryTable ($id_student_list)
        {
            $sql_query_1 =
                'CREATE TEMPORARY TABLE temp2 (
                  ID_Student varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

            $sql_of_list =
                implode(',', array_fill(0, count($id_student_list), '(?)'));

            $sql_query_2 =
                'INSERT INTO temp2
                    (ID_Student)
                VALUES
                    ' . $sql_of_list;

            DB::unprepared($sql_query_1);

            DB::statement($sql_query_2, $id_student_list);
        }
    }
