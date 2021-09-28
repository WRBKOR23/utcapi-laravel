<?php

namespace App\Depositories;

use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Models\Account;
use App\Models\DataVersionStudent;
use Illuminate\Support\Facades\DB;

class DataVersionStudentDepository implements DataVersionStudentDepositoryContract
{
    // DataVersionStudent Model
    private DataVersionStudent $model;

    public function __construct (DataVersionStudent $model)
    {
        $this->model = $model;
    }

    public function insert ($data)
    {
        DataVersionStudent::create($data);
    }

    public function get ($id_student)
    {
        return DataVersionStudent::select('schedule', 'notification', 'module_score', 'exam_schedule')
                                 ->find($id_student);
    }

    public function getSingleColumn ($id_student, $column_name)
    {
        return Account::find($id_student)->dataVersionStudent()->pluck($column_name)->first();
    }

    public function updateDataVersion ($id_student, $column_name)
    {
        DataVersionStudent::find($id_student)->increment($column_name);
    }

    public function updateMultiple ($id_student_list, $column_name)
    {
        DataVersionStudent::whereIn('id_student', $id_student_list)->increment($column_name);
    }

    public function upsertMultiple ($data)
    {
        DataVersionStudent::upsert($data, ['id_student'], ['schedule' => DB::raw('schedule+1')]);
    }
}
