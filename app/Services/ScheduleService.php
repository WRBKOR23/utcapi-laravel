<?php

namespace App\Services;

use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\DataVersionTeacherRepositoryContract;
use App\Repositories\Contracts\ScheduleRepositoryContract;

class ScheduleService implements Contracts\ScheduleServiceContract
{
    private ScheduleRepositoryContract $scheduleRepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;
    private DataVersionTeacherRepositoryContract $dataVersionTeacherRepository;

    /**
     * @param ScheduleRepositoryContract           $scheduleRepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     * @param DataVersionTeacherRepositoryContract $dataVersionTeacherRepository
     */
    public function __construct (ScheduleRepositoryContract           $scheduleRepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentRepository,
                                 DataVersionTeacherRepositoryContract $dataVersionTeacherRepository)
    {
        $this->scheduleRepository           = $scheduleRepository;
        $this->dataVersionStudentRepository = $dataVersionStudentRepository;
        $this->dataVersionTeacherRepository = $dataVersionTeacherRepository;
    }

    public function getStudentSchedules ($id_student) : array
    {
        $data         = $this->scheduleRepository->getStudentSchedules($id_student);
        $data_version = $this->dataVersionStudentRepository->getSingleColumn2($id_student,
                                                                              'schedule');

        return [
            'data'         => $data,
            'data_version' => $data_version
        ];
    }

    public function getTeacherSchedules ($id_teacher) : array
    {
        $data         = $this->scheduleRepository->getTeacherSchedules($id_teacher);
        $data_version = $this->dataVersionTeacherRepository->getSingleColumn2($id_teacher,
                                                                              'schedule');

        return [
            'data'         => $data,
            'data_version' => $data_version
        ];
    }
}
