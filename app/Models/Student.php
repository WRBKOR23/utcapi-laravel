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
            ->where('ID_Account', '=', $id_account)
            ->get()
            ->first();
    }

    public function getIDStudentsByFacultyClass ($class_list): array
    {
        $this->_createTemporaryTable($class_list);

        return DB::table(self::table_as)
            ->join('temp', 'stu.ID_Class', 'temp.ID_Class')
            ->pluck('ID_Student')
            ->toArray();
    }

    public function _createTemporaryTable ($class_list)
    {
        $sql_query_1 =
            'CREATE TEMPORARY TABLE temp (
                  ID_Class varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        $sql_of_list =
            implode(',', array_fill(0, count($class_list), '(?)'));

        $sql_query_2 =
            'INSERT INTO temp
                    (ID_Class)
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
                ID_Student, Student_Name, DoB_Student, ID_Class,
                ID_Card_Number, Phone_Number_Student, Address_Student
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE ID_Student = ID_Student';

        DB::insert($sql_query, $data);
    }

    public function updateMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'UPDATE
                student
            INNER JOIN
                account
            ON
                ID_Student = username
            SET
                ID_Account = id
            WHERE
                ID_Student IN (' . $part_of_sql . ')';

        DB::update($sql_query, $data);
    }
}
