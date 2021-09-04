<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    public const table = 'student';
    public const table_as = 'student as stu';

    public function get ($id_account)
    {
        return DB::table(self::table)
            ->where('id_account', '=', $id_account)
            ->get()
            ->first();
    }

    public function getIDStudentsByFacultyClass ($class_list): array
    {
        $this->_createTemporaryTable($class_list);

        return DB::table(self::table_as)
            ->join('temp', 'stu.id_class', 'temp.id_class')
            ->pluck('id_student')
            ->toArray();
    }

    public function _createTemporaryTable ($class_list)
    {
        $sql_query_1 =
            'CREATE TEMPORARY TABLE temp (
                  id_class varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        $sql_of_list =
            implode(',', array_fill(0, count($class_list), '(?)'));

        $sql_query_2 =
            'INSERT INTO temp
                    (id_class)
                VALUES
                    ' . $sql_of_list;

        DB::unprepared($sql_query_1);

        DB::statement($sql_query_2, $class_list);
    }

    public function insert($data)
    {
        DB::table(self::table)
            ->insert($data);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'INSERT INTO
                ' . self::table . '
            (
                id_student, student_name, birth, id_class,
                id_card_number, phone_number, address
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE id_student = id_student';

        DB::insert($sql_query, $data);
    }

    public function updateMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'UPDATE
                student as stu
            INNER JOIN
                account as acc
            ON
                id_student = username
            SET
                stu.id_account = acc.id_account
            WHERE
                id_student IN (' . $part_of_sql . ')';

        DB::update($sql_query, $data);
    }
}
