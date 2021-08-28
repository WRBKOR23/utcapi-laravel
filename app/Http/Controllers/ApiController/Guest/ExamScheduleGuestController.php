<?php

namespace App\Http\Controllers\ApiController\Guest;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\ExamScheduleGuestServiceContract;

class ExamScheduleGuestController extends Controller
{
    private ExamScheduleGuestServiceContract $examScheduleGuestService;

    /**
     * ExamScheduleGuestController constructor.
     * @param ExamScheduleGuestServiceContract $examScheduleGuestService
     */
    public function __construct (ExamScheduleGuestServiceContract $examScheduleGuestService)
    {
        $this->examScheduleGuestService = $examScheduleGuestService;
    }

    public function get ($id_student)
    {
        return $this->examScheduleGuestService->get($id_student);
    }
}
