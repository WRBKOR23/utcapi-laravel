<?php


namespace App\Depositories;


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
        return $this->model->get($id_teacher);
    }
}
