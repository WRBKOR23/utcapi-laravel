<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ScheduleServiceContract;

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
