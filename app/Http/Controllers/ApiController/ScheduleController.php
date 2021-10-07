<?php

namespace App\Http\Controllers\ApiController;

use App\Services\Contracts\ScheduleServiceContract;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    private ScheduleServiceContract $scheduleService;

    public function __construct (ScheduleServiceContract $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function getStudentSchedules ($id)
    {
        return $this->scheduleService->getStudentSchedules($id);
    }

    public function getTeacherSchedules ($id)
    {
        return $this->scheduleService->getTeacherSchedules($id);
    }
}
