<?php

namespace App\Services;

use App\Depositories\Contracts\ExamScheduleDepositoryContract;
use App\Services\Contracts\ExamScheduleServiceContract;

class ExamScheduleService implements ExamScheduleServiceContract
{
    private ExamScheduleDepositoryContract $examScheduleDepository;

    /**
     * ExamScheduleService constructor.
     * @param ExamScheduleDepositoryContract $examScheduleDepository
     */
    public function __construct (ExamScheduleDepositoryContract $examScheduleDepository)
    {
        $this->examScheduleDepository = $examScheduleDepository;
    }

    public function get ($id_student)
    {
        return $this->examScheduleDepository->get($id_student);
    }
}
