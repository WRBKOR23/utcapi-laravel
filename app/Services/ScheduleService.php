<?php


namespace App\Services;


use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Depositories\Contracts\DataVersionTeacherDepositoryContract;
use App\Depositories\Contracts\ScheduleDepositoryContract;

class ScheduleService implements Contracts\ScheduleServiceContract
{
    private ScheduleDepositoryContract $scheduleDepository;
    private DataVersionStudentDepositoryContract $dataVersionStudentDepository;
    private DataVersionTeacherDepositoryContract $dataVersionTeacherDepository;

    /**
     * @param ScheduleDepositoryContract $scheduleDepository
     * @param DataVersionStudentDepositoryContract $dataVersionStudentDepository
     * @param DataVersionTeacherDepositoryContract $dataVersionTeacherDepository
     */
    public function __construct (ScheduleDepositoryContract           $scheduleDepository,
                                 DataVersionStudentDepositoryContract $dataVersionStudentDepository,
                                 DataVersionTeacherDepositoryContract $dataVersionTeacherDepository)
    {
        $this->scheduleDepository           = $scheduleDepository;
        $this->dataVersionStudentDepository = $dataVersionStudentDepository;
        $this->dataVersionTeacherDepository = $dataVersionTeacherDepository;
    }

    public function getStudentSchedules ($id_student) : array
    {
        $data         = $this->scheduleDepository->getStudentSchedules($id_student);
        $data_version = $this->dataVersionStudentDepository->getSingleColumn($id_student, 'schedule');

        return [
            'data'         => $data,
            'data_version' => $data_version
        ];
    }

    public function getTeacherSchedules ($id_teacher) : array
    {
        $data         = $this->scheduleDepository->getTeacherSchedules($id_teacher);
        $data_version = $this->dataVersionTeacherDepository->getSingleColumn($id_teacher, 'schedule');

        return [
            'data'         => $data,
            'data_version' => $data_version
        ];
    }
}
