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
            ->where('ID_Student', '=', $id_student)
            ->select('Schedule', 'Notification', 'Module_Score', 'Exam_Schedule')
            ->get()
            ->first();
    }

    public function updateDataVersion ($id_student, $type)
    {
        DB::table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->increment($type);
    }

    public function updateMultiple ($id_notification)
    {
        $stu_na = DB::table(NotificationAccount::table_as)
            ->join(Student::table_as, 'stu.ID_Account', '=', 'na.ID_Account')
            ->where('na.ID_Notification', '=', $id_notification)
            ->select('ID_Student');

        DB::table(self::table_as)
            ->joinSub($stu_na, 'stu_na', 'dvs.ID_Student', '=', 'stu_na.ID_Student')
            ->increment('Notification');
    }

    public function updateMultiple2 ($id_student_list, $column_name)
    {
        DB::table(self::table_as)
            ->whereIn('ID_Student', $id_student_list)
            ->increment($column_name);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'INSERT INTO
                ' . self::table . '
            (
                ID_Student, Schedule, Notification, Module_Score, Exam_Schedule
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE ID_Student = ID_Student';

        DB::insert($sql_query, $data);
    }
}
