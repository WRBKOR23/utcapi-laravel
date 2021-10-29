<?php

namespace App\Services;

use App\Repositories\Contracts\ExamScheduleRepositoryContract;

class ExamScheduleService implements Contracts\ExamScheduleServiceContract
{
    private ExamScheduleRepositoryContract $examScheduleRepository;

    /**
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
