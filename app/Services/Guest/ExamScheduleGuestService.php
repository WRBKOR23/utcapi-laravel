<?php


namespace App\Services\Guest;


use App\Repositories\Contracts\ExamScheduleGuestDepositoryContract;
use App\Services\Contracts\Guest\ExamScheduleGuestServiceContract;

class ExamScheduleGuestService implements ExamScheduleGuestServiceContract
{
    private ExamScheduleGuestDepositoryContract $examScheduleGuestDepository;

    /**
     * ExamScheduleGuestService constructor.
     * @param ExamScheduleGuestDepositoryContract $examScheduleGuestDepository
     */
    public function __construct (ExamScheduleGuestDepositoryContract $examScheduleGuestDepository)
    {
        $this->examScheduleGuestDepository = $examScheduleGuestDepository;
    }

    public function get ($id_student)
    {
        return $this->examScheduleGuestDepository->get($id_student);
    }
}
