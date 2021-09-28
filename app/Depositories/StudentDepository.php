<?php

namespace App\Depositories;

use App\Depositories\Contracts\StudentDepositoryContract;
use App\Models\Account;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentDepository implements StudentDepositoryContract
{
    // Student Model
    private Student $model;

    public function __construct (Student $model)
    {
        $this->model = $model;
    }

    public function get ($id_account)
    {
        return Account::find($id_account)->student;
    }

    public function getIDStudentsBFC ($class_list) : array
    {
        $this->_createTemporaryTable($class_list);

        return DB::table(Student::table_as)
                 ->join('temp', 'stu.id_class', 'temp.id_class')
                 ->pluck('id_student')
                 ->toArray();
    }

    public function insertMultiple ($data)
    {
        Student::upsert($data, ['id_student'], ['id_student']);
    }

    public function updateMultiple ($id_student_list)
    {
        Student::whereIn('id_student', $id_student_list)
               ->join(Account::table_as, 'student.id_student', '=', 'acc.username')
               ->update(['student.id_account' => DB::raw('acc.id_account')]);
    }

    public function insert ($data)
    {
        Student::create($data);
    }

    public function _createTemporaryTable ($class_list)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp (
                  id_class varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        DB::unprepared($sql_query);
        DB::table('temp')->insert($class_list);
    }
}
