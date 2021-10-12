<?php

namespace App\Services;

use App\Repositories\Contracts\ExamScheduleRepositoryContract;
use App\Services\Contracts\ExamScheduleServiceContract;

class ExamScheduleService implements ExamScheduleServiceContract
{
    private ExamScheduleRepositoryContract $examScheduleRepository;

    /**
     * ExamScheduleService constructor.
     * @param ExamScheduleRepositoryContract $examScheduleRepository
     */
    public function __construct (ExamScheduleRepositoryContract $examScheduleRepository)
    {
        $this->examScheduleRepository = $examScheduleRepository;
    }

    public function get ($id_student)
    {
        return $this->examScheduleRepository->get($id_student);
    }
}
