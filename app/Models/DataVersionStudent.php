<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataVersionStudent extends Model
{
    use HasFactory;
    public const table = 'data_version_student';
    public const table_as = 'data_version_student as dvs';

    public function get ($id_student)
    {
        return DB::table(self::table)
            ->where('id_student', '=', $id_student)
            ->select('schedule', 'notification', 'module_score', 'exam_schedule')
            ->get()
            ->first();
    }

    public function updateDataVersion ($id_student, $type)
    {
        DB::table(self::table)
            ->where('id_student', '=', $id_student)
            ->increment($type);
    }

    public function updateMultiple ($id_notification)
    {
        $stu_na = DB::table(NotificationAccount::table_as)
            ->join(Student::table_as, 'stu.id_account', '=', 'na.id_account')
            ->where('na.id_notification', '=', $id_notification)
            ->select('id_student');

        DB::table(self::table_as)
            ->joinSub($stu_na, 'stu_na', 'dvs.id_student', '=', 'stu_na.id_student')
            ->increment('notification');
    }

    public function updateMultiple2 ($id_student_list, $column_name)
    {
        DB::table(self::table_as)
            ->whereIn('id_student', $id_student_list)
            ->increment($column_name);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'INSERT INTO
                ' . self::table . '
            (
                id_student, schedule, notification, module_score, exam_schedule
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE id_student = id_student';

        DB::insert($sql_query, $data);
    }
}
