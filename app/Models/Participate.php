<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Participate extends Model
    {
        public const table = 'participate';
        public const table_as = 'participate as par';

        public function getIDStudentsByModuleClass ($class_list) : array
        {
            $this->_createTemporaryTable($class_list);

            return DB::table(self::table_as)
                ->join('temp', 'par.ID_Module_Class', '=', 'temp.ID_Module_Class')
                ->pluck('ID_Student')
                ->toArray();
        }

        public function _createTemporaryTable ($class_list)
        {
            $sql_query_1 =
                'CREATE TEMPORARY TABLE temp (
                  ID_Module_Class varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

            $sql_of_list =
                implode(',', array_fill(0, count($class_list), '(?)'));

            $sql_query_2 =
                'INSERT INTO temp
                    (ID_Module_Class)
                VALUES
                    ' . $sql_of_list;

            DB::unprepared($sql_query_1);

            DB::statement($sql_query_2, $class_list);
        }

        public function insertMultiple ($part_of_sql, $data)
        {
            $sql_query =
                'INSERT INTO
                ' . self::table . '
            (
                ID_Module_Class, ID_Student, Process_Score, Test_Score,
                Theoretical_Score, Status_Studying
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE ID_Student = ID_Student';

            DB::insert($sql_query, $data);
        }
    }
