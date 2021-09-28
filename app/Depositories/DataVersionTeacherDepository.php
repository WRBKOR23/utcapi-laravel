<?php


namespace App\Depositories;


use App\Models\DataVersionStudent;
use App\Models\DataVersionTeacher;

class DataVersionTeacherDepository implements Contracts\DataVersionTeacherDepositoryContract
{
    private DataVersionTeacher $model;

    /**
     * DataVersionTeacherDepository constructor.
     * @param DataVersionTeacher $model
     */
    public function __construct (DataVersionTeacher $model)
    {
        $this->model = $model;
    }

    public function get ($id_teacher)
    {
        return DataVersionTeacher::select('schedule')->find($id_teacher);
    }

    public function getSingleColumn ($id_teacher, $column_name)
    {
        return DataVersionTeacher::where('id_teacher', '=', $id_teacher)->pluck($column_name)->first();
    }
}
