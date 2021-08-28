<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    public const table = 'account';
    public const table_as = 'account as acc';

    public function get ($username): array
    {
        return DB::table(self::table)
            ->where('username', '=', $username)
            ->select('id', 'username', 'password', 'permission')
            ->get()
            ->toArray();
    }

    public function getQLDTPassword ($username)
    {
        return DB::table(self::table)
            ->where('username', '=', $username)
            ->pluck('qldt_password')
            ->first();
    }

    public function getIDAccounts ($id_student_list): array
    {
        $this->_createTemporaryTable($id_student_list);

        return DB::table(self::table_as)
            ->join('temp1', 'acc.username', '=', 'temp1.ID_Student')
            ->pluck('id')
            ->toArray();
    }

    public function updateQLDTPassword ($username, $qldt_password)
    {
        DB::table(self::table)
            ->where('username', '=', $username)
            ->update(['qldt_password' => $qldt_password]);
    }

    public function updatePassword ($username, $password)
    {
        DB::table(self::table)
            ->where('username', '=', $username)
            ->update(['password' => $password]);
    }

    public function _createTemporaryTable ($id_student_list)
    {
        $sql_query_1 =
            'CREATE TEMPORARY TABLE temp1 (
                  ID_Student varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        $sql_of_list =
            implode(',', array_fill(0, count($id_student_list), '(?)'));

        $sql_query_2 =
            'INSERT INTO temp1
                    (ID_Student)
                VALUES
                    ' . $sql_of_list;

        DB::unprepared($sql_query_1);

        DB::statement($sql_query_2, $id_student_list);
    }

    public function insertGetId($data): int
    {
        return DB::table(self::table)
            ->insertGetId($data);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'INSERT INTO
                ' . self::table . '
            (
                 username, email, password, qldt_password, permission
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE username = username';

        DB::insert($sql_query, $data);
    }
}
