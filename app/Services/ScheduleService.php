<?php


namespace App\Services;


use App\Depositories\Contracts\ScheduleDepositoryContract;

class ScheduleService implements Contracts\ScheduleServiceContract
{
    private ScheduleDepositoryContract $model;

    /**
     * ScheduleService constructor.
     * @param ScheduleDepositoryContract $model
     */
    public function __construct (ScheduleDepositoryContract $model)
    {
        $this->model = $model;
    }

    public function getStudentSchedules ($id_student)
    {
        return $this->model->getStudentSchedules($id_student);
    }

    public function getTeacherSchedules ($id_teacher)
    {
        return $this->model->getTeacherSchedules($id_teacher);
    }
}
