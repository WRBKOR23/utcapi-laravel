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
                ->join('temp', 'par.id_module_class', '=', 'temp.id_module_class')
                ->pluck('id_student')
                ->toArray();
        }

        public function _createTemporaryTable ($class_list)
        {
            $sql_query_1 =
                'CREATE TEMPORARY TABLE temp (
                  id_module_class varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

            $sql_of_list =
                implode(',', array_fill(0, count($class_list), '(?)'));

            $sql_query_2 =
                'INSERT INTO temp
                    (id_module_class)
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
                id_module_class, id_student
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE id_student = id_student';

            DB::insert($sql_query, $data);
        }
    }
